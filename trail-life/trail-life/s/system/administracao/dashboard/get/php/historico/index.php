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

      $sql = 'SELECT id, cliente, filial, rota, tipo_carga, motorista, criador, criado, fechado FROM cargas;';
      $params = array();
      $result = $mysql->query($sql, $params);

      $data = array();

      while ($row = $result->fetch_assoc()) {
            $cliente = mysqli_fetch_assoc($mysql->query('SELECT empresa, cidade FROM clientes WHERE id = ?;', array($row['cliente'])));
            $filial = mysqli_fetch_assoc($mysql->query('SELECT estado, cidade, rua FROM filiais WHERE id = ?;', array($row['filial'])));
            $motorista = mysqli_fetch_assoc($mysql->query('SELECT nome FROM motoristas WHERE id = ?;', array($row['motorista'])));
            $usuario = mysqli_fetch_assoc($mysql->query('SELECT nome FROM usuarios_adm WHERE id = ?;', array($user)));

            $atualmente = "";
            $rota = json_decode($row['rota'], true);

            if (!empty($rota)) {
                  foreach ($rota as $key => $value) {
                        if ($value === 'atualmente') {
                              $atualmente = $key;
                              break;
                        }
                  }
            }

            $destino = Cypher::decryptStringUsingAES256($cliente['cidade'], $_ENV["CLIENTES_CIDADE_CYPHER_KEY"]);

            $data[] = array(
                  'id' => $row['id'],
                  'criado' => $row['criado'],
                  'criador' => $usuario['nome'],
                  'motorista' => $motorista['nome'],
                  'tipo_carga' => $row['tipo_carga'],
                  'destino' => $destino,
                  'atualmente' => $atualmente,
                  'ponto_de_partida' => $filial['cidade'],
                  'filial' => $filial['cidade'] . "/" . $filial['estado'] . " - " . $filial['rua'],
                  'cliente' => $cliente['empresa'],
                  'fechado' => $row['fechado']
            );
      }

      $requestHandler::returnJSON($data);
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>