<?php
define('BASE_DIR', '/opt/lampp/htdocs/');

require BASE_DIR . 'vendor/autoload.php';
require_once BASE_DIR . "global-modules/cypher/cypher.php";
require_once BASE_DIR . "global-modules/request-handler/request-handler.php";
require_once BASE_DIR . "global-modules/validate-api-data/validate-api-data.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();

$host = $_ENV["SQL_HOST_ADMINISTRACAO_ADD"];
$user = $_ENV["SQL_USER_ADMINISTRACAO_ADD"];
$password = $_ENV["SQL_PASSWORD_ADMINISTRACAO_ADD"];
$database = $_ENV["SQL_DATABASE_ADMINISTRACAO_ADD"];

$requestHandler = new RequestHandler();
$validateApiDate = new ValidateApiData();

try {
      if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      if (
            !(isset($authorizationHeader)) ||
            !$validateApiDate->validateUserPermission('usuarios_adm_session', 'usuarios_adm', $authorizationHeader, array('sudo'))
      ) {
            $requestHandler::throwReqException(403, 'Proibido. Você não tem permissão para acessar este recurso.');
      }

      $email = $_POST['email'];
      $nome = $_POST['nome'];
      $usuario = $_POST['usuario'];
      $senha = $_POST['senha'];
      $confirmeSenha = $_POST['confirme-senha'];
      $permissao = $_POST['permissao'];

      $mask = array(
            'email' => array(
                  'undefined' => false,
                  'maxLength' => 100,
                  'minLength' => 5,
                  'errorMessage' => array(
                        'undefined' => 'Por favor, forneça um email válido.',
                        'maxLength' => 'Por favor, forneça um email com menos carácteres.',
                        'minLength' => 'Por favor, forneça um email com mais carácteres.',
                  )
            ),
            'nome' => array(
                  'undefined' => false,
                  'maxLength' => 50,
                  'minLength' => 5,
                  'errorMessage' => array(
                        'undefined' => 'Por favor, forneça um nome válido.',
                        'maxLength' => 'Por favor, forneça um nome com menos carácteres.',
                        'minLength' => 'Por favor, forneça um nome com mais carácteres.',
                  )
            ),
            'usuario' => array(
                  'undefined' => false,
                  'maxLength' => 50,
                  'minLength' => 5,
                  'errorMessage' => array(
                        'undefined' => 'Por favor, forneça um usuário válido.',
                        'maxLength' => 'Por favor, forneça um usuário com menos carácteres.',
                        'minLength' => 'Por favor, forneça um usuário com mais carácteres.',
                  )
            ),
            'senha' => array(
                  'undefined' => false,
                  'maxLength' => 50,
                  'minLength' => 5,
                  'errorMessage' => array(
                        'undefined' => 'Por favor, forneça uma senha válida.',
                        'maxLength' => 'Por favor, forneça uma senha com menos carácteres.',
                        'minLength' => 'Por favor, forneça uma senha com mais carácteres.',
                  )
            ),
            'permissao' => array(
                  'undefined' => false,
                  'maxLength' => null,
                  'minLength' => null,
                  'errorMessage' => array(
                        'undefined' => 'Por favor, forneça uma permissão válida.',
                        'maxLength' => null,
                        'minLength' => null,
                  )
            )
      );

      foreach ($mask as $field => $rules) {
            if (!isset($_POST[$field])) {
                  $status = 400;
                  $label = $field;
                  $message = $rules['errorMessage']['undefined'];

                  $requestHandler::throwReqFormException($status, $label, $message);
            }

            if ($rules['maxLength'] !== null && strlen($_POST[$field]) > $rules['maxLength']) {
                  $status = 400;
                  $label = $field;
                  $message = $rules['errorMessage']['maxLength'];

                  $requestHandler::throwReqFormException($status, $label, $message);
            }

            if ($rules['minLength'] !== null && strlen($_POST[$field]) < $rules['minLength']) {
                  $status = 400;
                  $label = $field;
                  $message = $rules['errorMessage']['minLength'];

                  $requestHandler::throwReqFormException($status, $label, $message);
            }
      }

      if (!$validateApiDate->validateEmail($email)) {
            $status = 400;
            $label = 'email';
            $message = 'Por favor, forneça um email válido.';

            $requestHandler::throwReqFormException($status, $label, $message);
      }

      if ($senha !== $confirmeSenha) {
            $status = 400;
            $label = 'confirme-senha';
            $message = 'As senhas não conferem. Por favor, verifique se as duas senhas são iguais.';

            $requestHandler::throwReqFormException($status, $label, $message);
      }

      if ($permissao !== 'read' and $permissao !== 'write' and $permissao !== 'sudo') {
            $status = 400;
            $label = 'email';
            $message = 'Por favor, forneça uma permissão válida.';

            $requestHandler::throwReqFormException($status, $label, $message);
      }

      $h_email = Cypher::encryptStringUsingAES256($email, $_ENV["USUARIOS_ADM_EMAIL_CYPHER_KEY"]);
      $h_usuario = Cypher::encryptStringUsingSHA512($usuario);
      $h_senha = Cypher::encryptStringUsingSHA512($senha);

      $mysql = new Mysql($host, $user, $password, $database);
      $sql = 'INSERT INTO usuarios_adm (email, nome, usuario, senha, permissao) values (?, ?, ?, ?, ?);';
      $params = array($h_email, $nome, $h_usuario, $h_senha, $permissao);
      $result = $mysql->query($sql, $params);

      $requestHandler::return200();
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>