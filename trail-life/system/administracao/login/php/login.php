<?php
define('BASE_DIR', '/opt/lampp/htdocs/');

require BASE_DIR .'vendor/autoload.php';
require_once BASE_DIR . "trail-life/system/global-modules/mysql/mysql.php";
require_once BASE_DIR . "trail-life/system/global-modules/request-handler/request-handler.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();

$host=$_ENV["SQL_DB_HOST_ADMINISTRACAO_LOGIN"];
$user=$_ENV["SQL_DB_USER_ADMINISTRACAO_LOGIN"];
$password=$_ENV["SQL_DB_PASSWORD_ADMINISTRACAO_LOGIN"];
$database=$_ENV["SQL_DB_DATABASE_ADMINISTRACAO_LOGIN"];

$mysql = new Mysql($host, $user, $password, $database);

$requestHandler = new RequestHandler();

try {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $message = strlen($usuario) < 1 ? 'Por favor, forneça um usuário válido.' : 'Por favor, forneça um senha válida.';

        $requestHandler::throwReqFormException($status, $label, $message);
      }

      $h_usuario = hash('sha512', $usuario);
      $h_senha = hash('sha512', $senha);

      $sql = 'SELECT id, usuario FROM usuarios_adm WHERE usuario = ? AND senha = ?;';
      $params = array($h_usuario, $h_senha);
      $result = $mysql::query($sql, $params);

      if ($result->num_rows == 0) {
        $status = 400;
        $label = 'usuario';
        $message = 'Usuário ou senha errada!';

        $requestHandler::throwReqFormException($status, $label, $message);       
      } else {
        $id = $result->fetch_assoc()['id'];
        $a_token = bin2hex(random_bytes(20));

        $sql = 'INSERT INTO usuarios_adm_session (id, token) VALUES (?, ?);';
        $params = array($id, $a_token);
        $result = $mysql::query($sql, $params);

        setcookie('a_auth', $a_token, time() + 604800, "/");

        $requestHandler::return200();
      }

  } else {
      $requestHandler::throwReqError(405, 'Method Not Allowed. Please use a POST request.', date('Y-m-d H:i:s'));
  }
} catch (ReqException $e) {
  $requestHandler::handleReqCustomException($e);
} catch (ReqFormException $e) {
  $requestHandler::handleReqCustomException($e);
}
?>
