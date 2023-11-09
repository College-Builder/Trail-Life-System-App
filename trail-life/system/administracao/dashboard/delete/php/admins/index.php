<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "DELETE")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição DELETE.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      $usePermission = array('todas');
      $user = $validateApiDate->validateUserPermission('usuarios_adm_session', 'usuarios_adm', $authorizationHeader, $usePermission);

      $requestBody = file_get_contents('php://input');
      $decodedData = json_decode($requestBody, true);
      $ids = $decodedData['ids'];

      if (!isset($ids)) {
            $requestHandler::throwReqFormException(400, 'ids', 'Nenhum item selecionado para deletar.');
      }

      if (!is_array($ids)) {
            $ids = array($ids);
      }

      if (count($ids) > 100) {
            $requestHandler::throwReqFormException(400, 'ids', 'Por favor, forneça menos itens por vez para deletar.');
      }

      foreach($ids as $id){
            if (!is_numeric($id)) {
                  $requestHandler::throwReqFormException(400, 'ids', 'Por favor, forneça ids válidos.');
            }
      }

      foreach($ids as $id){
            $sql = 'DELETE FROM usuarios_adm_session WHERE id = ?;';
            $params = array($id);
            $result = $mysql->query($sql, $params);

            $sql = 'DELETE FROM usuarios_adm WHERE id = ?;';
            $params = array($id);
            $result = $mysql->query($sql, $params);
      }
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>