<?php
define('BASE_DIR', '/var/www/html/');

require BASE_DIR . 'vendor/autoload.php';
require_once BASE_DIR . "global-modules/administracao/validate-page-data/validate-page-data.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();
?>
<?php
$validatePageDate = new ValidatePageData();
$validatePageDate->validatePageAuth();
?>
<?php
$host = $_ENV["SQL_HOST_ADMINISTRACAO_DASHBOARD"];
$user = $_ENV["SQL_USER_ADMINISTRACAO_DASHBOARD"];
$password = $_ENV["SQL_PASSWORD_ADMINISTRACAO_DASHBOARD"];
$database = $_ENV["SQL_DATABASE_ADMINISTRACAO_DASHBOARD"];

$mysql = new Mysql($host, $user, $password, $database);
?>