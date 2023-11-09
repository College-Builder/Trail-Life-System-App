<?php include './util.php' ?>
<?php
$sql = 'SELECT id, empresa FROM clientes;';
$params = array();
$result = $mysql->query($sql, $params);

if ($result->num_rows === 0) {
      $timestamp = date('c'); 

      $message = "Por favor adicione pelo menos um cliente antes de adicionar uma carga.";
      $type = "warning";

      $url = "/system/administracao/dashboard/?" .
            "alert=" . urlencode($message) .
            "&timestamp=" . urlencode($timestamp) .
            "&type=" . urlencode($type);

      header("Location: " . $url);
      exit();
}

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
<?php
$sql = 'SELECT id, estado, cidade, rua FROM filiais;';
$params = array();
$result = $mysql->query($sql, $params);

$filiais = array();

while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $estado = $row['estado'];
      $cidade = $row['cidade'];
      $rua = $row['rua'];

      $filiais[] = array(
            "id" => $id,
            "estado" => $estado,
            "cidade" => $cidade,
            "rua" => $rua
      );
}
?>
<?php
$result = $mysql->query("SHOW COLUMNS FROM cargas WHERE Field = 'tipo_carga';");
$row = $result->fetch_assoc();
$enum_values = explode("','", substr($row['Type'], 6, -2));
?>
<?php
$sql = 'SELECT id, nome, status FROM motoristas;';
$params = array();
$result = $mysql->query($sql, $params);

if ($result->num_rows === 0) {
      $timestamp = date('c'); 

      $message = "Por favor adicione pelo menos um motorista antes de adicionar uma carga.";
      $type = "warning";

      $url = "/system/administracao/dashboard/?" .
            "alert=" . urlencode($message) .
            "&timestamp=" . urlencode($timestamp) .
            "&type=" . urlencode($type);

      header("Location: " . $url);
      exit();
}

$motoristas = array();

while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $nome = $row['nome'];
      $status = $row['status'];

      $motoristas[] = array(
            "id" => $id,
            "nome" => $nome,
            'status' => $status
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
      <script defer src="/system/administracao/dashboard/scripts/modules.js"></script>
      <!--
      <script defer src="https://college-builder.s3.amazonaws.com/trail-life/scripts/modules.js"></script>
      -->

      <script defer src="https://college-builder.s3.amazonaws.com/trail-life/scripts/auto-apply.js"></script>
      <!---->
      <!---->
      <link rel="stylesheet" href="https://college-builder.s3.amazonaws.com/trail-life/styles/index/index.css" />

      <link rel="stylesheet" href="/system/administracao/dashboard/styles/styles/styles.css">
      <!--
      <link rel="stylesheet" href="https://college-builder.s3.amazonaws.com/trail-life/styles/styles/styles.css" />
      -->

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
      <link rel="stylesheet" href="/system/administracao/dashboard/styles/interact-form/interact-form.css">
      <!---->
      <!---->
      <script defer src="/system/administracao/dashboard/scripts/action-form.js"></script>
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
                              Nova Carga
                        </h1>
                  </div>
                  <div class="default-hrz-padding interact-form-container__main-container">
                        <form class="default-form" method="POST"
                              action="/system/administracao/dashboard/add/carga/php/add/index.php"
                              sucess-message="Novo Admin criado com successo.">
                              <div>
                                    <div class="default-form__make-row">
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
                                          <div class="default-form__input-container">
                                                <label for="filial">Filial:</label>
                                                <div>
                                                      <div>
                                                            <button pseudo-select id="filial" name="filial"
                                                                  class="default-form__input-container__pseudo-select"
                                                                  type="button">
                                                                  <div pseudo-select__options-container>
                                                                        <div>
                                                                              <?php
                                                                              foreach ($filiais as $key => $value) {
                                                                                    echo "
                                                                                          <option
                                                                                                class='default-form__input-container__pseudo-select__pseudo_option'
                                                                                                value='" . $value['id'] . "'>
                                                                                                " . $value['cidade'] . "/" . $value['estado'] . " - " . $value['rua'] . "
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
                                    <div class="default-form__make-row">
                                          <div class="default-form__input-container">
                                                <label for="tipo-carga">Tipo de Carga:</label>
                                                <div>
                                                      <div>
                                                            <button pseudo-select id="tipo-carga" name="tipo-carga"
                                                                  class="default-form__input-container__pseudo-select"
                                                                  type="button">
                                                                  <div pseudo-select__options-container>
                                                                        <div>
                                                                              <?php
                                                                              foreach ($enum_values as $value) {
                                                                                    echo "
                                                                                          <option
                                                                                                class='default-form__input-container__pseudo-select__pseudo_option'
                                                                                                value='" . $value . "'>
                                                                                                " . ucfirst($value) . "
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
                                          <div class="default-form__input-container">
                                                <label for="motorista">Motorista:</label>
                                                <div>
                                                      <div>
                                                            <button pseudo-select id="motorista" name="motorista"
                                                                  class="default-form__input-container__pseudo-select"
                                                                  type="button">
                                                                  <div pseudo-select__options-container>
                                                                        <div>
                                                                              <?php
                                                                              foreach ($motoristas as $key => $value) {
                                                                                    $selectable = $value['status'] === 'livre' ? '' : 'unselectable';

                                                                                    echo "
                                                                                          <option
                                                                                                " . $selectable . "
                                                                                                class='default-form__input-container__pseudo-select__pseudo_option'
                                                                                                value='" . $value['id'] . "'>
                                                                                                " . $value['nome'] . " - " . ucfirst($value['status']) . "
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
                              </div>
                              <div>
                                    <div class="default-button-container">
                                          <button class="--red-button" type="submit">
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