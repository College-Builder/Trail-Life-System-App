<?php
define('BASE_DIR', '/opt/lampp/htdocs/');

require BASE_DIR . 'vendor/autoload.php';
require_once BASE_DIR . "global-modules/mysql/mysql.php";
require_once BASE_DIR . "global-modules/request-handler/request-handler.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();

$host = $_ENV["SQL_HOST_ADMINISTRACAO_LOGOUT"];
$user = $_ENV["SQL_USER_ADMINISTRACAO_LOGOUT"];
$password = $_ENV["SQL_PASSWORD_ADMINISTRACAO_LOGOUT"];
$database = $_ENV["SQL_DATABASE_ADMINISTRACAO_LOGOUT"];

$requestHandler = new RequestHandler();

try {
      if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
      }

      $authCookie = $_COOKIE['a_auth'];

      if (isset($authCookie)) {
            $mysql = new Mysql($host, $user, $password, $database);
            $sql = 'DELETE FROM usuarios_adm_session WHERE token = ?;';
            $params = array($authCookie);
            $result = $mysql->query($sql, $params);

            setcookie("a_auth", "", time() - 3600, "/");

            $requestHandler::return200();
      } else {
            $requestHandler::return200();
      }
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
}
?>