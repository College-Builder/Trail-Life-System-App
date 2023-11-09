<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      $usePermission = array('escrever', 'todas');
      $user = $validateApiDate->validateUserPermission('usuarios_adm_session', 'usuarios_adm', $authorizationHeader, $usePermission);

      $id = isset($_POST['id']) ? trim($_POST['id']) : null;
      $cliente = isset($_POST['cliente']) ? trim($_POST['cliente']) : null;

      $validateCargaData->validateId($cliente, 'cliente');
      $validateCargaData->validateCliente($cliente);

      $sql = 'UPDATE cargas SET cliente = ? WHERE id = ?;';
      $params = array($cliente, $id);
      $result = $mysql->query($sql, $params);
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>