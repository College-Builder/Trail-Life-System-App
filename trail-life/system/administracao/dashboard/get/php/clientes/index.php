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
      $sql = 'SELECT id, empresa, cnpj, estado, cidade, rua, numero, celular, email FROM clientes;';
      $params = array();
      $result = $mysql->query($sql, $params);

      $data = array();

      while ($row = $result->fetch_assoc()) {
            $data[] = array(
                  'id' => $row['id'],
                  'empresa' => $row['empresa'],
                  'cnpj' => Cypher::decryptStringUsingAES256($row['cnpj'], $_ENV["CLIENTES_CNPJ_CYPHER_KEY"]),
                  'estado' => Cypher::decryptStringUsingAES256($row['estado'], $_ENV["CLIENTES_ESTADO_CYPHER_KEY"]),
                  'cidade' => Cypher::decryptStringUsingAES256($row['cidade'], $_ENV["CLIENTES_CIDADE_CYPHER_KEY"]),
                  'rua' => Cypher::decryptStringUsingAES256($row['rua'], $_ENV["CLIENTES_RUA_CYPHER_KEY"]),
                  'numero' => Cypher::decryptStringUsingAES256($row['numero'], $_ENV["CLIENTES_NUMERO_CYPHER_KEY"]),
                  'celular' => Cypher::decryptStringUsingAES256($row['celular'], $_ENV["CLIENTES_CELULAR_CYPHER_KEY"]),
                  'email' => Cypher::decryptStringUsingAES256($row['email'], $_ENV["CLIENTES_EMAIL_CYPHER_KEY"]),
            );
      }

      $requestHandler::returnJSON($data);
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>