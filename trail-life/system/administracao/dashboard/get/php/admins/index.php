<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "GET")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição GET.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      if (
            !(isset($authorizationHeader)) ||
            !$validateApiDate->validateUserPermission('usuarios_adm_session', 'usuarios_adm', $authorizationHeader, array('ler', 'escrever', 'todas'))
      ) {
            $requestHandler::throwReqException(403, 'Proibido. Você não tem permissão para acessar este recurso.');
      }

      $mysql = new Mysql($host, $user, $password, $database);
      $sql = 'SELECT id, email, nome, permissao FROM usuarios_adm;';
      $params = array();
      $result = $mysql->query($sql, $params);

      $data = array();

      while ($row = $result->fetch_assoc()) {
            $data[] = array(
                  'id' => $row['id'],
                  'email' => Cypher::decryptStringUsingAES256($row['email'], $_ENV["USUARIOS_ADM_EMAIL_CYPHER_KEY"]),
                  'nome' => $row['nome'],
                  'permissao' => $row['permissao']
            );
      }

      $requestHandler::returnJSON($data);
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>