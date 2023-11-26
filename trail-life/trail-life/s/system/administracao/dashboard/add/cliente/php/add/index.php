<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      $usePermission = array('escrever', 'todas');
      $user = $validateApiDate->validateUserPermission($authorizationHeader, $usePermission);

      $empresa = isset($_POST['empresa']) ? trim($_POST['empresa']) : null;
      $cnpj = isset($_POST['cnpj']) ? trim($_POST['cnpj']) : null;
      $estado = isset($_POST['estado']) ? trim($_POST['estado']) : null;
      $cidade = isset($_POST['cidade']) ? trim($_POST['cidade']) : null;
      $rua = isset($_POST['rua']) ? trim($_POST['rua']) : null;
      $numero = isset($_POST['numero']) ? trim($_POST['numero']) : null;
      $celular = isset($_POST['celular']) ? trim($_POST['celular']) : null;
      $email = isset($_POST['email']) ? trim($_POST['email']) : null;

      $validateClienteData->validateEmpresa($empresa);
      $validateClienteData->validateCnpj($cnpj);
      $validateClienteData->validateEstado($estado);
      $validateClienteData->validateCidade($cidade);
      $validateClienteData->validateRua($rua);
      $validateClienteData->validateNumero($numero);
      $validateClienteData->validateCelular($celular);
      $validateClienteData->validateEmail($email);

      $h_cnpj = Cypher::encryptStringUsingAES256($cnpj, $_ENV["CLIENTES_CNPJ_CYPHER_KEY"]);
      $h_estado = Cypher::encryptStringUsingAES256($estado, $_ENV["CLIENTES_ESTADO_CYPHER_KEY"]);
      $h_cidade = Cypher::encryptStringUsingAES256($cidade, $_ENV["CLIENTES_CIDADE_CYPHER_KEY"]);
      $h_rua = Cypher::encryptStringUsingAES256($rua, $_ENV["CLIENTES_RUA_CYPHER_KEY"]);
      $h_numero = Cypher::encryptStringUsingAES256($numero, $_ENV["CLIENTES_NUMERO_CYPHER_KEY"]);
      $h_celular = Cypher::encryptStringUsingAES256($celular, $_ENV["CLIENTES_CELULAR_CYPHER_KEY"]);
      $h_email = Cypher::encryptStringUsingAES256($email, $_ENV["CLIENTES_EMAIL_CYPHER_KEY"]);

      $sql = 'INSERT INTO clientes (empresa, cnpj, estado, cidade, rua, numero, celular, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?);';
      $params = array($empresa, $h_cnpj, $h_estado, $h_cidade, $h_rua, $h_numero, $h_celular, $h_email);
      $result = $mysql->query($sql, $params);
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>
