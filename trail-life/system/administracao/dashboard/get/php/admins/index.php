<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "GET")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição GET.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      $usePermission = array('ler', 'escrever', 'todas');
      $user = $validateApiDate->validateUserPermission('usuarios_adm_session', 'usuarios_adm', $authorizationHeader, $usePermission);

      $sql = 'SELECT id, email, nome, permissao FROM usuarios_adm;';
      $params = array();
      $result = $mysql->query($sql, $params);

      $data = array();

      while ($row = $result->fetch_assoc()) {
            $data[] = array(
                  'id' => $row['id'],
                  'permissao' => $row['permissao'],
                  'email' => Cypher::decryptStringUsingAES256($row['email'], $_ENV["USUARIOS_ADM_EMAIL_CYPHER_KEY"]),
                  'nome' => $row['nome'],
            );
      }

      $requestHandler::returnJSON($data);
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>