<?php include './util.php' ?>
<?php
$token = $_COOKIE['m_auth'];

if (isset($token)) {
  $id = explode('-', $token)[0];
  $token = explode('-', $token)[1];

  $sql = 'SELECT id, token FROM motoristas_session WHERE id = ?;';
  $params = array($id);
  $result = $mysql->query($sql, $params);

  while ($row = $result->fetch_assoc()) {
    $sqlId = $row['id'];
    $sqlToken = Cypher::decryptStringUsingAES256($row['token'], $_ENV["MOTORISTAS_SESSION_TOKEN_CYPHER_KEY"]);

    if ($sqlToken === $_COOKIE['m_auth']) {
      header("Location: /system/motorista/dashboard/");
      exit();
    }
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
  <meta name="robots" content="noindex, nofollow" />
  <!---->
  <!---->
  <title>Dashboard | Login</title>
  <!---->
  <!---->
  <link rel="stylesheet" href="https://college-builder.s3.amazonaws.com/trail-life/system/login/styles/main/main.css" />
  <!---->
  <!---->
  <script defer src="https://college-builder.s3.amazonaws.com/trail-life/system/login/scripts/main.js" charset="utf-8"></script>
</head>

<body>
  <div default-alerts-container class="default-hrz-padding  default-alerts-container">
    <template>
      <div class="default-alerts-container__alert-container">
        <div>
          <div>
            <p class="default-alerts-container__alert-container__icon">
              <i default-alert-container__icon class="bi"></i>
            </p>
            <p>
              <i default-alert-container__message></i>
            </p>
          </div>
        </div>
      </div>
    </template>
  </div>
  <!---->
  <!---->
  <main>
    <div class="default-hrz-padding">
      <div>
        <div>
          <img
            src="https://college-builder.s3.amazonaws.com/trail-life/system/motorista/assets/images/brand/logo.png"
            alt="Trail Life Administração Logo" />
        </div>
        <div>
          <form email-form-container__form class="default-form" method="POST"
            action="/system/motorista/login/php/login/index.php" redirect="/system/motorista/dashboard/">
            <div>
              <div class="default-form__input-container">
                <label for="rg">RG:</label>
                <div>
                  <div>
                    <input placeholder="RG" type="text" name="rg" id="rg" pseudo-type="rg"/>
                  </div>
                  <span>
                    <i class="bi bi-exclamation-octagon"></i>
                    <i error-message></i>
                  </span>
                </div>
              </div>
              <div class="default-form__input-container">
                <label for="cpf">CPF:</label>
                <div>
                  <div>
                    <input placeholder="CPF" type="password" name="cpf" id="cpf" pseudo-type="cpf" />
                    <button tabindex="-1" type="button">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                  <span>
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
