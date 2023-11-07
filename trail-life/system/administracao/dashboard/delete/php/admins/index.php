<?php
include './util.php';
?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "DELETE")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição DELETE.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      if (
            !(isset($authorizationHeader)) ||
            !$validateApiDate->validateUserPermission('usuarios_adm_session', 'usuarios_adm', $authorizationHeader, array('sudo'))
      ) {
            $requestHandler::throwReqException(403, 'Proibido. Você não tem permissão para acessar este recurso.');
      }

      $request_body = file_get_contents('php://input');
      $data = json_decode($request_body, true); // true for associative array

      if (!isset($data['ids'])) {
            $requestHandler::throwReqFormException(400, 'ids', 'Por favor, forneça ids válidos.');
      }


      $ids = $data['ids'];

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