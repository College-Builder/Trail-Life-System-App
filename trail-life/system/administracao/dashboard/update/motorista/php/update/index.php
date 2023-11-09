<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      if (
            !(isset($authorizationHeader)) ||
            !$validateApiDate->validateUserPermission('usuarios_adm_session', 'usuarios_adm', $authorizationHeader, array('escrever', 'todas'))
      ) {
            $requestHandler::throwReqException(403, 'Proibido. Você não tem permissão para acessar este recurso.');
      }

      $id = isset($_POST['id']) ? trim($_POST['id']) : null;
      $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
      $celular = isset($_POST['celular']) ? trim($_POST['celular']) : null;
      $nome_emergencia = isset($_POST['nome-emergencia']) ? trim($_POST['nome-emergencia']) : null;
      $celular_emergencia = isset($_POST['celular-emergencia']) ? trim($_POST['celular-emergencia']) : null;
      $email_emergencia = isset($_POST['email-emergencia']) ? trim($_POST['email-emergencia']) : null;

      $validateMotoristaData->validateId($id);
      $validateMotoristaData->validateNome($nome);
      $validateMotoristaData->validateCelular($celular);
      $validateMotoristaData->validateNome($nome_emergencia, 'nome-emergencia');
      $validateMotoristaData->validateCelular($celular_emergencia, 'celular-emergencia');
      $validateMotoristaData->validateEmail($email_emergencia, 'email-emergencia');

      $h_celular = Cypher::encryptStringUsingAES256($celular, $_ENV["MOTORISTAS_CELULAR_CYPHER_KEY"]);
      $h_nome_emergencia = Cypher::encryptStringUsingAES256($nome_emergencia, $_ENV["MOTORISTAS_NOME_EMERGENCIA_CYPHER_KEY"]);
      $h_celular_emergencia = Cypher::encryptStringUsingAES256($celular_emergencia, $_ENV["MOTORISTAS_CELULAR_EMERGENCIA_CYPHER_KEY"]);
      $h_email_emergencia = Cypher::encryptStringUsingAES256($email_emergencia, $_ENV["MOTORISTAS_EMAIL_EMERGENCIA_CYPHER_KEY"]);

      $sql = 'UPDATE motoristas SET nome = ?, celular = ?, nome_emergencia = ?, celular_emergencia = ?, email_emergencia = ? WHERE id = ?;';
      $params = array($nome, $h_celular, $h_nome_emergencia, $h_celular_emergencia, $h_email_emergencia, $id);
      $result = $mysql->query($sql, $params);
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>