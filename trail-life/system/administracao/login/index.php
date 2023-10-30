<?php
      define('BASE_DIR', '/opt/lampp/htdocs/');

      require BASE_DIR .'vendor/autoload.php';
      require_once BASE_DIR . "global-modules/mysql/mysql.php";

      $dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
      $dotenv->load();

      $host=$_ENV["SQL_HOST_ADMINISTRACAO_DASHBOARD"];
      $user=$_ENV["SQL_USER_ADMINISTRACAO_DASHBOARD"];
      $password=$_ENV["SQL_PASSWORD_ADMINISTRACAO_DASHBOARD"];
      $database=$_ENV["SQL_DATABASE_ADMINISTRACAO_DASHBOARD"];

      if(isset($_COOKIE['a_auth'])) {
            $mysql = new Mysql($host, $user, $password, $database);

            $a_token = $_COOKIE['a_auth'];
            
            $sql = 'SELECT id, token FROM usuarios_adm_session WHERE token = ?;';
            $params = array($a_token);
            $result = $mysql::query($sql, $params);

            if ($result->num_rows != 0) {
                  header("Location: http://localhost/trail-life/system/administracao/dashboard/");
                  exit();
            }
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
    <link
      rel="shortcut icon"
      href="https://college-builder.s3.amazonaws.com/trail-life/landing-page/assets/images/brand/icon.png"
      type="image/x-icon"
    />
    <!---->
    <!---->
    <script
      defer
      src="https://college-builder.s3.amazonaws.com/trail-life/scripts/modules.js"
    ></script>
    <script
      defer
      src="https://college-builder.s3.amazonaws.com/trail-life/scripts/auto-apply.js"
    ></script>
    <!---->
    <!---->
    <link
      rel="stylesheet"
      href="https://college-builder.s3.amazonaws.com/trail-life/styles/index/index.css"
    />
    <link
      rel="stylesheet"
      href="https://college-builder.s3.amazonaws.com/trail-life/styles/styles/styles.css"
    />
    <link
      rel="stylesheet"
      href="https://college-builder.s3.amazonaws.com/trail-life/styles/controller/controller.css"
    />
    <!---->
    <!---->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <!---->
    <!---->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    <!--
      Custom head tags
    -->
    <meta name="robots" content="noindex, nofollow" />
    <!---->
    <!---->
    <link rel="stylesheet" href="./styles/main/main.css" />
    <!---->
    <!---->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!---->
    <!---->
    <script defer src="./scripts/main.js?v=<?= time() ?>" charset="utf-8"></script>
  </head>
  <body>
    <div default-alert class="default-hrz-padding default-alert">
      <div>
        <div>
          <span>
            <i alert-icon class="bi"></i>
            <i alert-message></i>
          </span>
          <button onclick="closeAlert()">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      </div>
    </div>
    <main>
      <div class="default-hrz-padding">
        <div>
          <div>
            <img
              src="https://college-builder.s3.amazonaws.com/trail-life/system/administracao/assets/images/brand/logo.png"
              alt="Trail Life Administração Logo"
            />
          </div>
          <div>
            <form
              email-form-container__form
              class="default-form"
              method="POST"
              action="php/login.php"
            >
              <div>
                <div class="default-form__input-container">
                  <label for="login-form-username">Usuário:</label>
                  <div default-input>
                    <div>
                      <input
                        placeholder="Usuário"
                        type="text"
                        name="usuario"
                        id="login-form-username"
                      />
                    </div>
                    <span class="default-input__error-message">
                      <i class="bi bi-exclamation-octagon"></i>
                      <i error-message></i>
                    </span>
                  </div>
                </div>
                <div class="default-form__input-container">
                  <label for="login-form-password">Senha:</label>
                  <div default-input>
                    <div>
                      <input
                        placeholder="Senha"
                        type="password"
                        name="senha"
                        id="login-form-password"
                      />
                      <button type="button">
                        <i class="bi bi-eye"></i>
                      </button>
                    </div>
                    <span class="default-input__error-message">
                      <i class="bi bi-exclamation-octagon"></i>
                      <i error-message></i>
                    </span>
                  </div>
                </div>
              </div>
              <div>
                <div class="default-form__button-container">
                  <button class="--red-button" type="submit">
                    <span class="default-button__loading">
                      <i class="bi bi-arrow-repeat"></i>
                    </span>
                    Enviar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
