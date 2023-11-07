<?php
include './util.php';
?>
<?php
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

      $email = isset($_POST['email']) ? trim($_POST['email']) : null;
      $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
      $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : null;
      $senha = isset($_POST['senha']) ? trim($_POST['senha']) : null;
      $confirmeSenha = isset($_POST['confirme-senha']) ? trim($_POST['confirme-senha']) : null;
      $permissao = isset($_POST['permissao']) ? trim($_POST['permissao']) : null;

      $mask = array(
            'email' => array(
                  'undefined' => false,
                  'maxLength' => 50,
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

      $h_usuario = Cypher::encryptStringUsingSHA512($usuario);
      $h_email = Cypher::encryptStringUsingAES256($email, $_ENV["USUARIOS_ADM_EMAIL_CYPHER_KEY"]);
      $h_senha = Cypher::encryptStringUsingSHA512($senha);

      foreach ($mask as $field => $rules) {
            if (!isset($_POST[$field]) || strlen($_POST[$field]) === 0) {
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

            if ($field === 'email' && !$validateApiDate->validateEmail($email)) {
                  $status = 400;
                  $label = 'email';
                  $message = 'Por favor, forneça um email válido.';

                  $requestHandler::throwReqFormException($status, $label, $message);
            } 

            if ($field === 'nome' && !$validateApiDate->validateInputString($nome)) {
                  $status = 400;
                  $label = "nome";
                  $message = 'Por favor, utilize apenas letras e números.';

                  $requestHandler::throwReqFormException($status, $label, $message);
            }

            if ($field === 'usuario' && !$validateApiDate->validateInputString($usuario)) {
                  $status = 400;
                  $label = "usuario";
                  $message = 'Por favor, utilize apenas letras e números.';

                  $requestHandler::throwReqFormException($status, $label, $message);
            }

            if ($field === 'usuario') {
                  $mysql = new Mysql($host, $user, $password, $database);
                  $sql = 'SELECT id FROM usuarios_adm WHERE usuario = ?;';
                  $params = array($h_usuario);
                  $result = $mysql->query($sql, $params);

                  if ($result->num_rows !== 0) {
                        $status = 400;
                        $label = 'usuario';
                        $message = 'Usuário já existe. Por favor, tente utilizar outro nome de usuário.';

                        $requestHandler::throwReqFormException($status, $label, $message);
                  }
            }

            if ($field === 'senha' && $senha !== $confirmeSenha) {
                  $status = 400;
                  $label = 'confirme-senha';
                  $message = 'As senhas não conferem. Por favor, verifique se as duas senhas são iguais.';

                  $requestHandler::throwReqFormException($status, $label, $message);
            }

            if ($field === 'permissao' && ($permissao !== 'read' and $permissao !== 'write' and $permissao !== 'sudo')) {
                  $status = 400;
                  $label = 'permissao';
                  $message = 'Por favor, forneça uma permissão válida.';

                  $requestHandler::throwReqFormException($status, $label, $message);
            }
      }

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