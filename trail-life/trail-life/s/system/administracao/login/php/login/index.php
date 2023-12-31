<?php include("./util.php") ?>
<?php
try {
  if (!($_SERVER["REQUEST_METHOD"] == "POST")) { 
    $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
  }

  $usuario = $_POST["usuario"];
  $senha = $_POST["senha"];

  if (!isset($usuario) || !isset($senha)) {
    $status = 400;
    $label = !isset($usuario) ? 'usuario' : 'senha';
    $message = !isset($usuario) ? 'Por favor, forneça um usuário válido.' : 'Por favor, forneça um senha válida.';

    $requestHandler::throwReqFormException($status, $label, $message);
  }

  if (strlen($usuario) < 1 || strlen($senha) < 1) {
    $status = 400;
    $label = strlen($usuario) < 1 ? 'usuario' : 'senha';
    $message = strlen($usuario) < 1 ? 'Por favor, forneça um usuário válido.' : 'Por favor, forneça uma senha válida.';

    $requestHandler::throwReqFormException($status, $label, $message);
  }

  $h_usuario = Cypher::encryptStringUsingSHA512($usuario);
  $h_senha = Cypher::encryptStringUsingSHA512($senha);

  $sql = 'SELECT id, usuario FROM usuarios_adm WHERE usuario = ? AND senha = ? AND fechado IS NULL;';
  $params = array($h_usuario, $h_senha);
  $result = $mysql->query($sql, $params);

  if ($result->num_rows == 0) {
    $status = 400;
    $label = 'usuario';
    $message = 'Não foi possível realizar o login. Por favor, verifique se as credenciais estão corretas.';

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
} catch (ReqException $e) {
  $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
  $requestHandler::handleCustomException($e);
}
?>
