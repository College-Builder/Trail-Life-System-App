<?php include './util.php' ?>
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

      <script defer src="/system/administracao/dashboard/scripts/auto-apply.js"></script>
      <!--
      <script defer src="https://college-builder.s3.amazonaws.com/trail-life/scripts/auto-apply.js"></script>
      -->
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
      <title>Add Cliente | Administração</title>
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
                              Novo Cliente
                        </h1>
                  </div>
                  <div class="default-hrz-padding interact-form-container__main-container">
                        <form class="default-form" method="POST"
                              action="/system/administracao/dashboard/add/cliente/php/add/index.php"
                              sucess-message="Novo Cliente criado com successo.">
                              <div>
                                    <div class="default-form__make-row">
                                          <div class="default-form__input-container">
                                                <label for="empresa">Empresa</label>
                                                <div>
                                                      <div>
                                                            <input id="empresa" name="empresa" type="text"
                                                                  placeholder="Empresa">
                                                      </div>
                                                      <span>
                                                            <i class="bi bi-exclamation-octagon"></i>
                                                            <i error-message></i>
                                                      </span>
                                                </div>
                                          </div>
                                          <div class="default-form__input-container">
                                                <label for="cnpj">CNPJ:</label>
                                                <div>
                                                      <div>
                                                            <input id="cnpj" name="cnpj" type="text" pseudo-type="cnpj" placeholder="CNPJ">
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
                                                                  placeholder="Cidade">
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
                                                            <input id="rua" name="rua" type="text" placeholder="Rua">
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
                                                                  placeholder="Número">
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
                                                            <input id="celular" name="celular" type="text" pseudo-type="phone"
                                                                  placeholder="celular">
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
                                                            <input id="email" name="email" type="text" placeholder="Email">
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