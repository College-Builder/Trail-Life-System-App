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
      <link rel="stylesheet" href="../styles/interact-form/interact-form.css">
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
                                          <label for="cod-cliente">Código Cliente:</label>
                                          <div>
                                                <div>
                                                      <button pseudo-select id="cod-cliente"
                                                            class="default-form__input-container__pseudo-select"
                                                            type="button">
                                                            <div pseudo-select__options-container>
                                                                  <div>
                                                                        <option
                                                                              class="default-form__input-container__pseudo-select__pseudo_option"
                                                                              value="1">
                                                                              Lorem ipsum dolor sit amet consectetur
                                                                        </option>
                                                                        <option
                                                                              class="default-form__input-container__pseudo-select__pseudo_option"
                                                                              value="2">
                                                                              adipisicing elit. Vel pariatur alias ut ex
                                                                        </option>
                                                                        <option
                                                                              class="default-form__input-container__pseudo-select__pseudo_option"
                                                                              value="3">
                                                                              3
                                                                        </option>
                                                                  </div>
                                                            </div>
                                                      </button>
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
                                          <label for="placa-cavalo">Placa Cavalo:</label>
                                          <div>
                                                <div>
                                                      <input id="placa-cavalo" type="text" pseudo-type="plate-br" placeholder="Placa Cavalo">
                                                </div>
                                                <span class="default-input__error-message">
                                                      <i class="bi bi-exclamation-octagon"></i>
                                                      <i error-message></i>
                                                </span>
                                          </div>
                                    </div>
                                    <div class="default-form__make-row">
                                          <div class="default-form__input-container">
                                                <label for="placa-carreta-1">Placa Carreta 1:</label>
                                                <div>
                                                      <div>
                                                            <input id="placa-carreta-1" type="text" pseudo-type="plate-br"
                                                                  placeholder="Placa Carreta 1">
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="placa-carreta-2">Placa Carreta 2:</label>
                                                <div>
                                                      <div>
                                                            <input id="placa-carreta-2" type="text" pseudo-type="plate-br"
                                                                  placeholder="Placa Carreta 2">
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="placa-carreta-3">Placa Carreta 3:</label>
                                                <div>
                                                      <div>
                                                            <input id="placa-carreta-3" type="text" pseudo-type="plate-br"
                                                                  placeholder="Placa Carreta 3">
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="default-form__input-container">
                                          <label for="tipo-de-carga">Tipo de Carga:</label>
                                          <div>
                                                <div>
                                                      <button pseudo-select id="tipo-de-carga"
                                                            class="default-form__input-container__pseudo-select"
                                                            type="button">
                                                            <div pseudo-select__options-container>
                                                                  <div>
                                                                        <option
                                                                              class="default-form__input-container__pseudo-select__pseudo_option"
                                                                              value="1">
                                                                              Lorem ipsum dolor sit amet consectetur
                                                                        </option>
                                                                        <option
                                                                              class="default-form__input-container__pseudo-select__pseudo_option"
                                                                              value="2">
                                                                              adipisicing elit. Vel pariatur alias ut ex
                                                                        </option>
                                                                        <option
                                                                              class="default-form__input-container__pseudo-select__pseudo_option"
                                                                              value="3">
                                                                              3
                                                                        </option>
                                                                  </div>
                                                            </div>
                                                      </button>
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
                                          <label for="ponto-de-partida">Ponto de Partida:</label>
                                          <div>
                                                <div>
                                                      <button pseudo-select id="ponto-de-partida"
                                                            class="default-form__input-container__pseudo-select"
                                                            type="button">
                                                            <div pseudo-select__options-container>
                                                                  <div>
                                                                        <option
                                                                              class="default-form__input-container__pseudo-select__pseudo_option"
                                                                              value="1">
                                                                              Lorem ipsum dolor sit amet
                                                                              consectetur
                                                                        </option>
                                                                        <option
                                                                              class="default-form__input-container__pseudo-select__pseudo_option"
                                                                              value="2">
                                                                              adipisicing elit. Vel pariatur alias
                                                                              ut ex
                                                                        </option>
                                                                        <option
                                                                              class="default-form__input-container__pseudo-select__pseudo_option"
                                                                              value="3">
                                                                              3
                                                                        </option>
                                                                  </div>
                                                            </div>
                                                      </button>
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
                                                <label for="destino-cidade">Destino - Cidade:</label>
                                                <div>
                                                      <div>
                                                            <input id="destino-cidade" type="text" placeholder="Cidade">
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="destino-numero">Destino - Número:</label>
                                                <div>
                                                      <div>
                                                            <input id="destino-numero" type="number"
                                                                  placeholder="Número">
                                                      </div>
                                                      <span class="default-input__error-message">
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="destino - estado">Destino - Estado</label>
                                                <div>
                                                      <div>
                                                            <button pseudo-select id="destino-estado"
                                                                  class="default-form__input-container__pseudo-select"
                                                                  type="button">
                                                                  <div pseudo-select__options-container>
                                                                        <div>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="AC">Acre</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="AL">Alagoas</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="AP">Amapá</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="AM">Amazonas</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="BA">Bahia</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="CE">Ceará</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="DF">Distrito Federal</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="ES">Espírito Santo</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="GO">Goiás</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="MA">Maranhão</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="MT">Mato Grosso</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="MS">Mato Grosso do Sul
                                                                              </option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="MG">Minas Gerais</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="PA">Pará</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="PB">Paraíba</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="PR">Paraná</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="PE">Pernambuco</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="PI">Piauí</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="RJ">Rio de Janeiro</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="RN">Rio Grande do Norte
                                                                              </option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="RS">Rio Grande do Sul
                                                                              </option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="RO">Rondônia</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="RR">Roraima</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="SC">Santa Catarina</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="SP">São Paulo</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="SE">Sergipe</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="TO">Tocantins</option>
                                                                        </div>
                                                                  </div>
                                                            </button>
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