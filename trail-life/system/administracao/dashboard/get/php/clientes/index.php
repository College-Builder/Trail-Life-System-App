<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "GET")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição GET.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      $usePermission = array('ler', 'escrever', 'todas');
      $user = $validateApiDate->validateUserPermission($authorizationHeader, $usePermission);

      $sql = 'SELECT id, empresa, cnpj, estado, cidade, rua, numero, celular, email FROM clientes WHERE fechado IS NULL;';
      $params = array();
      $result = $mysql->query($sql, $params);

      $data = array();

      while ($row = $result->fetch_assoc()) {
            $data[] = array(
                  'id' => $row['id'],
                  'email' => Cypher::decryptStringUsingAES256($row['email'], $_ENV["CLIENTES_EMAIL_CYPHER_KEY"]),
                  'celular' => Cypher::decryptStringUsingAES256($row['celular'], $_ENV["CLIENTES_CELULAR_CYPHER_KEY"]),
                  'numero' => Cypher::decryptStringUsingAES256($row['numero'], $_ENV["CLIENTES_NUMERO_CYPHER_KEY"]),
                  'rua' => Cypher::decryptStringUsingAES256($row['rua'], $_ENV["CLIENTES_RUA_CYPHER_KEY"]),
                  'cidade' => Cypher::decryptStringUsingAES256($row['cidade'], $_ENV["CLIENTES_CIDADE_CYPHER_KEY"]),
                  'estado' => Cypher::decryptStringUsingAES256($row['estado'], $_ENV["CLIENTES_ESTADO_CYPHER_KEY"]),
                  'cnpj' => Cypher::decryptStringUsingAES256($row['cnpj'], $_ENV["CLIENTES_CNPJ_CYPHER_KEY"]),
                  'empresa' => $row['empresa'],
            );

      }

      $requestHandler::returnJSON($data);
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>