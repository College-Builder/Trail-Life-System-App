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

      $cliente = isset($_POST['cliente']) ? trim($_POST['cliente']) : null;
      $filial = isset($_POST['filial']) ? trim($_POST['filial']) : null;
      $tipo_carga = isset($_POST['tipo-carga']) ? trim($_POST['tipo-carga']) : null;
      $motorista = isset($_POST['motorista']) ? trim($_POST['motorista']) : null;

      $validateCargaData->validateId($cliente, 'cliente');
      $validateCargaData->validateCliente($cliente);
      $validateCargaData->validateId($filial, 'filial');
      $validateCargaData->validateFilial($filial);
      $validateCargaData->validateCarga($tipo_carga);
      $validateCargaData->validateId($motorista, 'motorista');
      $validateCargaData->validateMotorista($motorista);

      $origem = mysqli_fetch_assoc($mysql->query('SELECT cidade FROM filiais WHERE id = ?;', array($filial)))['cidade'];

      $rota = array(
            ''. $origem => 'atualmente',
      );

      $sql = 'UPDATE motoristas SET status = ? WHERE id = ?;';
      $params = array('encarregado', $motorista);
      $result = $mysql->query($sql, $params);

      $sql = 'INSERT INTO cargas (cliente, filial, tipo_carga, rota, motorista, criador) values (?, ?, ?, ?, ?, ?);';
      $params = array($cliente, $filial, $tipo_carga, json_encode($rota), $motorista, $user);
      $result = $mysql->query($sql, $params);
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>