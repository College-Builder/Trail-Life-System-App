<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      $usePermission = array('todas');
      $user = $validateApiDate->validateUserPermission($authorizationHeader, $usePermission);

      $id = isset($_POST['id']) ? trim($_POST['id']) : null;
      $email = isset($_POST['email']) ? trim($_POST['email']) : null;
      $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
      $permissao = isset($_POST['permissao']) ? trim($_POST['permissao']) : null;

      $validateAdminData->validateId($id);
      $validateAdminData->validateEmail($email);
      $validateAdminData->validateNome($nome);
      $validateAdminData->validatePermissao($permissao);

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