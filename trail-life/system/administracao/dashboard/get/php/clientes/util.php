<?php
define('BASE_DIR', '/opt/lampp/htdocs/');

require BASE_DIR . 'vendor/autoload.php';
require_once BASE_DIR . "global-modules/cypher/cypher.php";
require_once BASE_DIR . "global-modules/request-handler/request-handler.php";
require_once BASE_DIR . "global-modules/validate-api-data/validate-api-data.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();
?>
<?php
$host = $_ENV["SQL_HOST_ADMINISTRACAO_GET"];
$user = $_ENV["SQL_USER_ADMINISTRACAO_GET"];
$password = $_ENV["SQL_PASSWORD_ADMINISTRACAO_GET"];
$database = $_ENV["SQL_DATABASE_ADMINISTRACAO_GET"];

$mysql = new Mysql($host, $user, $password, $database);
?>
<?php
$requestHandler = new RequestHandler();
$validateApiDate = new ValidateApiData();
?>