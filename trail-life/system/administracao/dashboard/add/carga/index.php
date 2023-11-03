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
<!DOCTYPE html>
<html lang="en">

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
      <link rel="stylesheet"
            href="https://college-builder.s3.amazonaws.com/trail-life/styles/controller/controller.css" />
      <!---->
      <!---->
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet" />
      <!---->
      <!---->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
      <!--
      Custom head tags
      -->
      <title>Add Carga | Administração</title>
      <!---->
      <!---->
      <link rel="stylesheet" href="../styles/interact-form/interact-form.css?v=<?php echo time(); ?>">
</head>

<body>
      <main>
            <div class="interact-form-container">
                  <div class="default-hrz-padding interact-form-container__header-container">
                        <h1>
                              <i class="bi bi-box-seam"></i>
                              Nova Carga
                        </h1>
                  </div>
                  <div class="default-hrz-padding interact-form-container__main-container">
                        <form class="default-form" method="" action="">
                              <div>
                                    <div class="default-form__input-container">
                                          <label for="">Código Cliente:</label>
                                          <div>
                                                <div>
                                                      <select name="" id="">
                                                            <option value="">Hello</option>
                                                            <option value="">Word</option>
                                                      </select>
                                                      <span>
                                                            <i class="bi bi-chevron-down"></i>
                                                      </span>
                                                </div>
                                                <span class="default-input__error-message">
                                                      <i class="bi bi-exclamation-octagon"></i>
                                                      <i error-message></i>
                                                </span>
                                          </div>
                                    </div>
                                    <div class="default-form__input-container">
                                          <label for="">Placa Cavalo:</label>
                                          <div>
                                                <div>
                                                      <input type="text" placeholder="Placa Cavalo">
                                                </div>
                                                <span class="default-input__error-message">
                                                      <i class="bi bi-exclamation-octagon"></i>
                                                      <i error-message></i>
                                                </span>
                                          </div>
                                    </div>
                                    <div class="default-form__make-row">
                                          <div class="default-form__input-container">
                                                <label for="">Placa Carreta 1:</label>
                                                <div>
                                                      <div>
                                                            <input type="text" placeholder="Placa Carreta 1">
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="">Placa Carreta 2:</label>
                                                <div>
                                                      <div>
                                                            <input type="text" placeholder="Placa Carreta 2">
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="">Placa Carreta 3:</label>
                                                <div>
                                                      <div>
                                                            <input type="text" placeholder="Placa Carreta 3">
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="default-form__input-container">
                                          <label for="">Solicitante:</label>
                                          <div>
                                                <div>
                                                      <select name="" id="">
                                                            <option value="">Hello</option>
                                                            <option value="">Word</option>
                                                      </select>
                                                      <span>
                                                            <i class="bi bi-chevron-down"></i>
                                                      </span>
                                                </div>
                                                <span class="default-input__error-message">
                                                      <i class="bi bi-exclamation-octagon"></i>
                                                      <i error-message></i>
                                                </span>
                                          </div>
                                    </div>
                                    <div class="default-form__input-container">
                                          <label for="">Status Transporte:</label>
                                          <div>
                                                <div>
                                                      <select name="" id="">
                                                            <option value="">Hello</option>
                                                            <option value="">Word</option>
                                                      </select>
                                                      <span>
                                                            <i class="bi bi-chevron-down"></i>
                                                      </span>
                                                </div>
                                                <span class="default-input__error-message">
                                                      <i class="bi bi-exclamation-octagon"></i>
                                                      <i error-message></i>
                                                </span>
                                          </div>
                                    </div>
                                    <div class="default-form__make-row">
                                          <div class="default-form__input-container">
                                                <label for="">Tipo de Carga:</label>
                                                <div>
                                                      <div>
                                                            <select name="" id="">
                                                                  <option value="">Hello</option>
                                                                  <option value="">Word</option>
                                                            </select>
                                                            <span>
                                                                  <i class="bi bi-chevron-down"></i>
                                                            </span>
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="">Situação Transporte:</label>
                                                <div>
                                                      <div>
                                                            <select name="" id="">
                                                                  <option value="">Hello</option>
                                                                  <option value="">Word</option>
                                                            </select>
                                                            <span>
                                                                  <i class="bi bi-chevron-down"></i>
                                                            </span>
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="default-form__make-row">
                                          <div class="default-form__input-container">
                                                <label for="">Ponto de Partida:</label>
                                                <div>
                                                      <div>
                                                            <select name="" id="">
                                                                  <option value="">Hello</option>
                                                                  <option value="">Word</option>
                                                            </select>
                                                            <span>
                                                                  <i class="bi bi-chevron-down"></i>
                                                            </span>
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="">Destino:</label>
                                                <div>
                                                      <div>
                                                            <select name="" id="">
                                                                  <option value="">Hello</option>
                                                                  <option value="">Word</option>
                                                            </select>
                                                            <span>
                                                                  <i class="bi bi-chevron-down"></i>
                                                            </span>
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <div>
                                    <div class="default-button-container">
                                          <button class="--red-button">
                                                <span class="default-button__loading">
                                                      <i class="bi bi-arrow-repeat"></i>
                                                </span>
                                                Adicionar
                                          </button>
                                    </div>
                              </div>
                        </form>
                  </div>
            </div>
      </main>
</body>

</html>