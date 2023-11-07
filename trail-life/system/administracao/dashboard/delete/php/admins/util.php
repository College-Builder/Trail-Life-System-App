<?php
define('BASE_DIR', '/opt/lampp/htdocs/');

require BASE_DIR . 'vendor/autoload.php';
require_once BASE_DIR . "global-modules/cypher/cypher.php";
require_once BASE_DIR . "global-modules/request-handler/request-handler.php";
require_once BASE_DIR . "global-modules/validate-api-data/validate-api-data.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();

$host = $_ENV["SQL_HOST_ADMINISTRACAO_DEL"];
$user = $_ENV["SQL_USER_ADMINISTRACAO_DEL"];
$password = $_ENV["SQL_PASSWORD_ADMINISTRACAO_DEL"];
$database = $_ENV["SQL_DATABASE_ADMINISTRACAO_DEL"];

$requestHandler = new RequestHandler();
$validateApiDate = new ValidateApiData();
$mysql = new Mysql($host, $user, $password, $database);
?>