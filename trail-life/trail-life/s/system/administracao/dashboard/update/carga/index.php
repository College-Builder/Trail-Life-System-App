<?php include './util.php' ?>
<?php
$id = $_GET['id'];

if (!isset($id) || !is_numeric($id)) {
      header("Location: /trail-life/s/system/administracao/dashboard");
      exit();
}

$sql = 'SELECT id, cliente FROM cargas WHERE id = ? AND fechado IS NULL;';
$params = array($id);
$result = $mysql->query($sql, $params);

if ($result->num_rows !== 1) {
      header("Location: /trail-life/s/system/administracao/dashboard");
      exit();
}

$row = mysqli_fetch_assoc($result);

$id = $row['id'];
?>
<?php
$sql = 'SELECT id, empresa FROM clientes WHERE fechado IS NULL;';
$params = array();
$result = $mysql->query($sql, $params);

$clientes = array();

while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $empresa = $row['empresa'];

      $clientes[] = array(
            "id" => $id,
            "empresa" => $empresa
      );
}
?>
<!DOCTYPE html>
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
      <title>Modificar Carga | Administração</title>
      <!---->
      <!---->
      <link rel="stylesheet" href="https://college-builder.s3.amazonaws.com/trail-life/system/administracao/styles/interact-form/interact-form.css">
      <!---->
      <!---->
      <script defer src="https://college-builder.s3.amazonaws.com/trail-life/system/administracao/scripts/action-form.js"></script>
</head>

<body>
      <div default-alerts-container class="default-hrz-padding default-alerts-container">
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
            <div class="interact-form-container">
                  <div class="default-hrz-padding interact-form-container__header-container">
                        <h1>
                              <i class="bi bi-box-seam"></i>
                              Modificar Carga
                        </h1>
                  </div>
                  <div class="default-hrz-padding interact-form-container__main-container">
                        <form class="default-form" method="POST"
                              action="/trail-life/s/system/administracao/dashboard/update/carga/php/update"
                              sucess-message="Carga modificada com successo.">
                              <div>
                                    <div class="default-form__input-container">
                                          <label for="cliente">Cliente:</label>
                                          <div>
                                                <div>
                                                      <button pseudo-select id="cliente" name="cliente"
                                                            class="default-form__input-container__pseudo-select"
                                                            type="button">
                                                            <div pseudo-select__options-container>
                                                                  <div>
                                                                        <?php
                                                                        foreach ($clientes as $key => $value) {
                                                                              echo "
                                                                                          <option
                                                                                                class='default-form__input-container__pseudo-select__pseudo_option'
                                                                                                value='" . $value['id'] . "'>
                                                                                                " . $value['empresa'] . "
                                                                                          </option>
                                                                                    ";
                                                                        }
                                                                        ?>
                                                                  </div>
                                                            </div>
                                                      </button>
                                                      <span>
                                                            <i class="bi bi-chevron-down"></i>
                                                      </span>
                                                </div>
                                                <span>
                                                      <i class="bi bi-exclamation-octagon"></i>
                                                      <i error-message></i>
                                                </span>
                                          </div>
                                    </div>
                              </div>
                              <div>
                                    <div class="default-button-container">
                                          <button class="--red-button" type="submit">
                                                <span class="default-button__loading">
                                                      <i class="bi bi-arrow-repeat"></i>
                                                </span>
                                                Modificar
                                          </button>
                                    </div>
                              </div>
                        </form>
                  </div>
            </div>
      </main>
</body>

</html>
