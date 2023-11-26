<?php
define('BASE_DIR', '/var/www/html/');

require BASE_DIR . 'vendor/autoload.php';
require_once BASE_DIR . "global-modules/cypher/cypher.php";
require_once BASE_DIR . "global-modules/request-handler/request-handler.php";
require_once BASE_DIR . "global-modules/administracao/validate-api-data/validate-api-data.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();
?>
<?php
$host = $_ENV["SQL_HOST_ADMINISTRACAO_UPDATE"];
$user = $_ENV["SQL_USER_ADMINISTRACAO_UPDATE"];
$password = $_ENV["SQL_PASSWORD_ADMINISTRACAO_UPDATE"];
$database = $_ENV["SQL_DATABASE_ADMINISTRACAO_UPDATE"];

$mysql = new Mysql($host, $user, $password, $database);
?>
<?php 
$requestHandler = new RequestHandler();
$validateApiDate = new ValidateApiData();
$validateMotoristaData = new ValidateMotoristaData()
?>