<?php
define('BASE_DIR', '/opt/lampp/htdocs/');

require BASE_DIR . 'vendor/autoload.php';
require_once BASE_DIR . "global-modules/mysql/mysql.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();

$host = $_ENV["SQL_HOST_ADMINISTRACAO_DASHBOARD"];
$user = $_ENV["SQL_USER_ADMINISTRACAO_DASHBOARD"];
$password = $_ENV["SQL_PASSWORD_ADMINISTRACAO_DASHBOARD"];
$database = $_ENV["SQL_DATABASE_ADMINISTRACAO_DASHBOARD"];

if (isset($_COOKIE['a_auth'])) {
  $mysql = new Mysql($host, $user, $password, $database);
  $sql = 'SELECT id, token FROM usuarios_adm_session WHERE token = ?;';
  $params = array($_COOKIE['a_auth']);
  $result = $mysql->query($sql, $params);

  if ($result->num_rows == 0) {
    header("Location: /system/administracao/login/");
    exit();
  }
} else {
  header("Location: /system/administracao/login/");
  exit();
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="theme-color" content="#B20C30" />
  <!---->
  <!---->
  <link rel="shortcut icon"
    href="https://college-builder.s3.amazonaws.com/trail-life/landing-page/assets/images/brand/icon.png"
    type="image/x-icon" />
  <!---->
  <!---->
  <script defer src="https://college-builder.s3.amazonaws.com/trail-life/scripts/modules.js"></script>
  <script defer src="https://college-builder.s3.amazonaws.com/trail-life/scripts/auto-apply.js"></script>
  <!---->
  <!---->
  <link rel="stylesheet" href="https://college-builder.s3.amazonaws.com/trail-life/styles/index/index.css" />
  <link rel="stylesheet" href="https://college-builder.s3.amazonaws.com/trail-life/styles/styles/styles.css" />
  <link rel="stylesheet" href="https://college-builder.s3.amazonaws.com/trail-life/styles/controller/controller.css" />
  <!---->
  <!---->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
  <!---->
  <!---->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <!--
      Custom head tags
  -->
  <title>Dashboard | Administração</title>
  <!---->
  <!---->
  <link rel="stylesheet" href="./styles/main/main.css" type="text/css" media="screen"
    title="no title" charset="utf-8" />
  <link rel="stylesheet" href="./styles/aside/aside.css" type="text/css" media="all" />
  <link rel="stylesheet" href="./styles/header/header.css" type="text/css" media="all" />
  <link rel="stylesheet" href="./styles/dashboard-panel/dashboard-panel.css">
  <!---->
  <!---->
  <script defer src="./scripts/aside.js?v=5.0" charset="utf-8"></script>
  <script defer src="./scripts/dashboard-panel.js?v=2.0" charset="utf-8"></script>
  <!--
      Dashboard-Panel 1
  -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!---->
  <!---->
  <link rel="stylesheet" href="./styles/dashboard-panel-1/dashboard-panel-1.css?v=<?php echo time(); ?>">
</head>

<body>
  <header>
    <div class="default-hrz-padding">
      <div>
        <div>
          <img
            src="https://college-builder.s3.amazonaws.com/trail-life/system/administracao/assets/images/brand/logo.png"
            alt="Trail Life Administração Logo" />
        </div>
        <button open-aside-menu-button>
          <i class="bi bi-list"></i>
        </button>
      </div>
    </div>
  </header>
  <!---->
  <!---->
  <div aside-menu-container class="aside-menu-container">
    <aside aside-menu class="aside-menu">
      <div>
        <div>
          <p><i class="bi bi-person-circle"></i></p>
          <p>Admin</p>
        </div>
        <hr />
        <div>
          <ul>
            <li>
              <button aside-menu-container__option for-dashboard-panel="1" class="default-icon-button">
                <i class="bi bi-box-seam"></i>
                <i>Controle Financeiro</i>
              </button>
            </li>
            <li>
              <button aside-menu-container__option for-dashboard-panel="2" class="default-icon-button">
                <i class="bi bi-box-seam"></i>
                <i>Entregas</i>
              </button>
            </li>
            <li>
              <button aside-menu-container__option for-dashboard-panel="3" class="default-icon-button">
                <i class="bi bi-box-seam"></i>
                <i>Entregas</i>
              </button>
            </li>
            <li>
              <button aside-menu-container__option for-dashboard-panel="4" class="default-icon-button">
                <i class="bi bi-box-seam"></i>
                <i>Entregas</i>
              </button>
            </li>
          </ul>
        </div>
        <div>
          <button logout-button class="default-icon-button">
            <i class="bi bi-box-seam"></i>
            Sair
          </button>
        </div>
      </div>
    </aside>
    <button close-aside-menu-button></button>
  </div>
  <!---->
  <!---->
  <main>
    <div class="dashboard-system-container">
      <!---->
      <!---->
      <div dash-board-menu-container class="dashboard-system-container__aside-menu-container"></div>
      <!---->
      <!---->
      <div class="dashboard-system-container__dashboard-container">
        <!---->
        <!---->
        <div dashboard-panel-id="1">
          <?php include './dashboard-panels/dashboard-panel-1/index.php'; ?>
        </div>
        <!---->
        <!---->
        <div dashboard-panel-id="2">
          <?php include './dashboard-panels/dashboard-panel-2/index.php'; ?>
        </div>
        <!---->
        <!---->
        <div dashboard-panel-id="3" style="background-color: green"></div>
        <!---->
        <!---->
        <div dashboard-panel-id="4" style="background-color: red"></div>
      </div>
    </div>
  </main>
</body>

</html>