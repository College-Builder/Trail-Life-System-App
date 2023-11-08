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
            !$validateApiDate->validateUserPermission('usuarios_adm_session', 'usuarios_adm', $authorizationHeader, array('todas'))
      ) {
            $requestHandler::throwReqException(403, 'Proibido. Você não tem permissão para acessar este recurso.');
      }

      $id = isset($_POST['id']) ? trim($_POST['id']) : null;
      $email = isset($_POST['email']) ? trim($_POST['email']) : null;
      $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
      $permissao = isset($_POST['permissao']) ? trim($_POST['permissao']) : null;

      $mask = array(
            'id' => array(
                  'undefined' => false,
                  'number' => true,
                  'maxLength' => null,
                  'minLength' => null,
                  'errorMessage' => array(
                        'undefined' => 'Por favor, forneça um id válido.',
                        'number' => 'Por favor, forneça um id válido.',
                        'maxLength' => null,
                        'minLength' => null,
                  )
            ),
            'email' => array(
                  'undefined' => false,
                  'number' => null,
                  'maxLength' => 50,
                  'minLength' => 5,
                  'errorMessage' => array(
                        'undefined' => 'Por favor, forneça um email válido.',
                        'number' => null,
                        'maxLength' => 'Por favor, forneça um email com menos carácteres.',
                        'minLength' => 'Por favor, forneça um email com mais carácteres.',
                  )
            ),
            'nome' => array(
                  'undefined' => false,
                  'number' => null,
                  'maxLength' => 50,
                  'minLength' => 5,
                  'errorMessage' => array(
                        'undefined' => 'Por favor, forneça um nome válido.',
                        'number' => null,
                        'maxLength' => 'Por favor, forneça um nome com menos carácteres.',
                        'minLength' => 'Por favor, forneça um nome com mais carácteres.',
                  )
            ),
            'permissao' => array(
                  'undefined' => false,
                  'number' => null,
                  'maxLength' => null,
                  'minLength' => null,
                  'errorMessage' => array(
                        'undefined' => 'Por favor, forneça uma permissão válida.',
                        'number' => null,
                        'maxLength' => null,
                        'minLength' => null,
                  )
            )
      );

      foreach ($mask as $field => $rules) {
            if ($rules['undefined'] === false && !isset($_POST[$field]) || strlen($_POST[$field]) === 0) {
                  $status = 400;
                  $label = $field;
                  $message = $rules['errorMessage']['undefined'];

                  $requestHandler::throwReqFormException($status, $label, $message);
            }

            if ($rules['number'] !== null && !is_numeric($_POST[$field])) {
                  $status = 400;
                  $label = $field;
                  $message = $rules['errorMessage']['number'];

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

            if ($field === 'permissao' && ($permissao !== 'ler' and $permissao !== 'escrever' and $permissao !== 'todas')) {
                  $status = 400;
                  $label = 'permissao';
                  $message = 'Por favor, forneça uma permissão válida.';

                  $requestHandler::throwReqFormException($status, $label, $message);
            }
      }

      $h_email = Cypher::encryptStringUsingAES256($email, $_ENV["USUARIOS_ADM_EMAIL_CYPHER_KEY"]);

      $sql = 'UPDATE usuarios_adm SET email = ?, nome = ?, permissao = ? WHERE id = ?;';
      $params = array($h_email, $nome, $permissao, $id);
      $result = $mysql->query($sql, $params);
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>