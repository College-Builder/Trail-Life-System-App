<?php include './util.php' ?>
<?php
$id = $_GET['id'];

if (!isset($id) || !is_numeric($id)) {
      header("Location: /system/administracao/dashboard");
      exit();
}

$sql = 'SELECT empresa, cnpj, estado, cidade, rua, numero, celular, email FROM clientes WHERE id = ?;';
$params = array($id);
$result = $mysql->query($sql, $params);

if ($result->num_rows !== 1) {
      header("Location: /system/administracao/dashboard");
      exit();
}

$row = mysqli_fetch_assoc($result);

$empresa = $row['empresa'];
$cnpj = Cypher::decryptStringUsingAES256($row['cnpj'], $_ENV["CLIENTES_CNPJ_CYPHER_KEY"]);
$estado = Cypher::decryptStringUsingAES256($row['estado'], $_ENV["CLIENTES_ESTADO_CYPHER_KEY"]);
$cidade = Cypher::decryptStringUsingAES256($row['cidade'], $_ENV["CLIENTES_CIDADE_CYPHER_KEY"]);
$rua = Cypher::decryptStringUsingAES256($row['rua'], $_ENV["CLIENTES_RUA_CYPHER_KEY"]);
$numero = Cypher::decryptStringUsingAES256($row['numero'], $_ENV["CLIENTES_NUMERO_CYPHER_KEY"]);
$celular = Cypher::decryptStringUsingAES256($row['celular'], $_ENV["CLIENTES_CELULAR_CYPHER_KEY"]);
$email = Cypher::decryptStringUsingAES256($row['email'], $_ENV["CLIENTES_EMAIL_CYPHER_KEY"]);
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
      <title>Modificar Cliente | Administração</title>
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
                              Modificar
                              <?php
                              echo $empresa;
                              ?>
                        </h1>
                  </div>
                  <div class="default-hrz-padding interact-form-container__main-container">
                        <form class="default-form" method="POST"
                              action="/system/administracao/dashboard/update/cliente/php/update/index.php"
                              sucess-message="Empresa <?php echo $empresa ?> modificada com successo.">
                              <div>
                                    <div class="default-form__make-row">
                                          <div class="default-form__input-container">
                                                <label for="empresa">Empresa</label>
                                                <div>
                                                      <div>
                                                            <input id="empresa" name="empresa" type="text"
                                                                  placeholder="Empresa" value="<?php echo $empresa ?>">
                                                      </div>
                                                      <span>
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="cnpj">Cnpj:</label>
                                                <div>
                                                      <div>
                                                            <input id="cnpj" name="cnpj" type="text" pseudo-type="cnpj"
                                                                  placeholder="Cnpj" value="<?php echo $cnpj ?>">
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
                                                <label for="estado">Estado:</label>
                                                <div>
                                                      <div>
                                                            <button pseudo-select id="estado" name="estado"
                                                                  class="default-form__input-container__pseudo-select"
                                                                  type="button" select-value="<?php echo $estado ?>">
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
                                                                                    value="MG">Minas Gerais</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="MS">Mato Grosso do Sul
                                                                              </option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="MT">Mato Grosso</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="PA">Pará</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="PB">Paraíba</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="PE">Pernambuco</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="PI">Piauí</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="PR">Paraná</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="RJ">Rio de Janeiro</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="RN">Rio Grande do Norte
                                                                              </option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="RO">Rondônia</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="RR">Roraima</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="RS">Rio Grande do Sul
                                                                              </option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="SC">Santa Catarina</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="SE">Sergipe</option>
                                                                              <option
                                                                                    class="default-form__input-container__pseudo-select__pseudo_option"
                                                                                    value="SP">São Paulo</option>
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
                                                      <span>
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="cidade">Cidade</label>
                                                <div>
                                                      <div>
                                                            <input id="cidade" name="cidade" type="text"
                                                                  placeholder="Cidade" value="<?php echo $cidade ?>">
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
                                                <label for="rua">Rua</label>
                                                <div>
                                                      <div>
                                                            <input id="rua" name="rua" type="text" placeholder="Rua" value="<?php echo $rua ?>">
                                                      </div>
                                                      <span>
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="numero">Número</label>
                                                <div>
                                                      <div>
                                                            <input id="numero" name="numero" type="number"
                                                                  placeholder="Número" value="<?php echo $numero ?>">
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
                                                <label for="celular">Celular</label>
                                                <div>
                                                      <div>
                                                            <input id="Celular" name="celular" type="text"
                                                                  pseudo-type="phone" placeholder="celular" value="<?php echo $celular ?>">
                                                      </div>
                                                      <span>
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="email">Email:</label>
                                                <div>
                                                      <div>
                                                            <input id="email" name="email" type="text"
                                                                  placeholder="Email" value="<?php echo $email ?>">
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