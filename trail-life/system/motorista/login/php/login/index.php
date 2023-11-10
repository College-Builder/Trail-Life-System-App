<?php include("./util.php") ?>
<?php
try {
  if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
    $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
  }

  $rg = $_POST["rg"];
  $cpf = $_POST["cpf"];

  if (!isset($rg) || !isset($cpf)) {
    $status = 400;
    $label = !isset($rg) ? 'rg' : 'cpf';
    $message = !isset($rg) ? 'Por favor, forneça um RG válido.' : 'Por favor, forneça um CPF válida.';

    $requestHandler::throwReqFormException($status, $label, $message);
  }

  if (strlen($rg) < 1 || strlen($cpf) < 1) {
    $status = 400;
    $label = strlen($rg) < 1 ? 'rg' : 'cpf';
    $message = strlen($rg) < 1 ? 'Por favor, forneça um RG válido.' : 'Por favor, forneça uma CPF válida.';

    $requestHandler::throwReqFormException($status, $label, $message);
  }

  $h_rg = Cypher::encryptStringUsingSHA512($rg);
  $h_cpf = Cypher::encryptStringUsingSHA512($cpf);

  $sql = 'SELECT id, nome FROM motoristas WHERE cpf = ? AND rg = ?;';
  $params = array($h_cpf, $h_rg);
  $result = $mysql->query($sql, $params);

  if ($result->num_rows == 0) {
    $status = 400;
    $label = 'rg';
    $message = 'Não foi possível realizar o login. Por favor, verifique se as credenciais estão corretas.';

    $requestHandler::throwReqFormException($status, $label, $message);
  }

  $row = mysqli_fetch_assoc($result);
  $id = $row['id'];

  $m_token = $id . '-' . bin2hex(random_bytes(20));
  $h_m_token = Cypher::encryptStringUsingAES256($m_token, $_ENV["MOTORISTAS_SESSION_TOKEN_CYPHER_KEY"]);

  $sql = 'INSERT INTO motoristas_session (id, token) VALUES (?, ?);';
  $params = array($id, $h_m_token);
  $result = $mysql->query($sql, $params);

  setcookie('m_auth', $m_token, time() + 604800, "/");

  /*
  $sql = 'SELECT id, usuario FROM usuarios_adm WHERE usuario = ? AND senha = ?;';
  $params = array($h_usuario, $h_senha);
  $result = $mysql->query($sql, $params);

  if ($result->num_rows == 0) {
    $status = 400;
    $label = 'usuario';
    $message = 'Usuário ou senha errada!';

    $requestHandler::throwReqFormException($status, $label, $message);
  }

  $row = mysqli_fetch_assoc($result);
  $id = $row['id'];

  $a_token = $id . '-' . bin2hex(random_bytes(20));
  $h_a_token = Cypher::encryptStringUsingAES256($a_token, $_ENV["USUARIOS_ADM_SESSION_TOKEN_CYPHER_KEY"]);

  $sql = 'INSERT INTO usuarios_adm_session (id, token) VALUES (?, ?);';
  $params = array($id, $h_a_token);
  $result = $mysql->query($sql, $params);

  setcookie('a_auth', $a_token, time() + 604800, "/");
  */
} catch (ReqException $e) {
  $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
  $requestHandler::handleCustomException($e);
}
?>