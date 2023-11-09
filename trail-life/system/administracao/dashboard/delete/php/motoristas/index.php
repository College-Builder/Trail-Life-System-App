<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "DELETE")) {
            #$requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição DELETE.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      $usePermission = array('escrever', 'todas');
      #$user = $validateApiDate->validateUserPermission('usuarios_adm_session', 'usuarios_adm', $authorizationHeader, $usePermission);

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

      foreach ($ids as $id) {
            if (!is_numeric($id)) {
                  $requestHandler::throwReqFormException(400, 'ids', 'Por favor, forneça ids válidos.');
            }

            $sql = 'SELECT id FROM cargas WHERE motorista = ?;';
            $params = array($id);
            $result = $mysql->query($sql, $params);

            if ($result->num_rows !== 0) {
                  $sql = 'SELECT nome FROM motoristas WHERE id = ?;';
                  $params = array($id);
                  $result = $mysql->query($sql, $params);

                  $row = mysqli_fetch_assoc($result);

                  $requestHandler::throwReqFormException(400, 'ids', 'O motorista ' . $row['nome'] . ' não pode ser removido, pois atualmente está associado a uma carga.');
            }
      }

      foreach ($ids as $id) {
            $sql = 'DELETE FROM motoristas WHERE id = ?;';
            $params = array($id);
            $result = $mysql->query($sql, $params);
      }
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>