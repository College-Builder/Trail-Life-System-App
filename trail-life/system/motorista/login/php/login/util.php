<?php
define('BASE_DIR', '/opt/lampp/htdocs/');

require BASE_DIR . 'vendor/autoload.php';
require_once BASE_DIR . "global-modules/mysql/mysql.php";
require_once BASE_DIR . "global-modules/request-handler/request-handler.php";
require_once BASE_DIR . "global-modules/cypher/cypher.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();

$host = $_ENV["SQL_HOST_MOTORISTA_LOGIN"];
$user = $_ENV["SQL_USER_MOTORISTA_LOGIN"];
$password = $_ENV["SQL_PASSWORD_MOTORISTA_LOGIN"];
$database = $_ENV["SQL_DATABASE_MOTORISTA_LOGIN"];

$mysql = new Mysql($host, $user, $password, $database);
$requestHandler = new RequestHandler();
?>