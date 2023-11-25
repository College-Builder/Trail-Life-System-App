<?php
define('BASE_DIR', '/opt/lampp/htdocs/');

require BASE_DIR . 'vendor/autoload.php';
require_once BASE_DIR . "global-modules/mysql/mysql.php";
require_once BASE_DIR . "global-modules/cypher/cypher.php";
require_once BASE_DIR . "global-modules/administracao/validate-page-data/validate-page-data.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();
?>
<?php
$validatePageDate = new ValidatePageData();
$validatePageDate->validatePageAuth();
?>
<?php
$host = $_ENV["SQL_HOST_ADMINISTRACAO_UPDATE"];
$user = $_ENV["SQL_USER_ADMINISTRACAO_UPDATE"];
$password = $_ENV["SQL_PASSWORD_ADMINISTRACAO_UPDATE"];
$database = $_ENV["SQL_DATABASE_ADMINISTRACAO_UPDATE"];

$mysql = new Mysql($host, $user, $password, $database);
?>