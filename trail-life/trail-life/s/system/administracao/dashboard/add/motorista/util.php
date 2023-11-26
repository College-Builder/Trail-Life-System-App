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