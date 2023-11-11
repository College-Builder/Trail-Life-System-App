<?php
$sql = 'SELECT id FROM cargas WHERE motorista = ?;';
$params = array($motorista_id);
$result = $mysql->query($sql, $params);

$numCargas = $result->num_rows;

$row = mysqli_fetch_assoc($result);

$cargaId = $row['id'];
?>
<div class="default-panel-container" apply-hrz-padding>
      <div class="dashboard-panel-1-content-container">
            <!---->
            <!---->
            <div style="<?php if ($numCargas !== 0) {echo "display: none";} ?>" class="dashboard-panel-1-content-container__no-content-container">
                  <div class="default-alerts-container__alert-container --on --attention">
                        <div>
                              <div>
                                    <p class="default-alerts-container__alert-container__icon">
                                          <i class="bi bi-exclamation-octagon"></i>
                                    </p>
                                    <p>
                                          <i>Nenhum entrega registrada ainda. Por favor, volte mais tarde e tente
                                                novamente.</i>
                                    </p>
                              </div>
                        </div>
                  </div>
            </div>
            <!---->
            <!---->
            <div style="<?php if ($numCargas === 0) {echo "display: none";} ?>" class="dashboard-panel-1-content-container__true-content-container">
                  <div class="dashboard-panel-1-content-container__true-content-container__content-container">
                        <span
                              class="dashboard-panel-1-content-container__true-content-container__content-container__id">
                              #<?php echo $cargaId ?>
                        </span>
                        <div
                              class="dashboard-panel-1-content-container__true-content-container__content-container__info-container --yellow">
                              <p>
                                    <i>Código rastreio: <?php echo $cargaId ?></i>
                              </p>
                              <p>
                                    <i>Retirar em:</i>
                              </p>
                              <p>
                                    <i>Solicitante:</i>
                              </p>
                              <p>
                                    <i>Destino:</i>
                              </p>
                        </div>
                        <div
                              class="dashboard-panel-1-content-container__true-content-container__content-container__link-container --yellow">
                              <a href="">
                                    <i class="bi bi-map"></i>
                                    Abrir Pontos
                              </a>
                        </div>
                  </div>
                  <hr>
                  <div class="dashboard-panel-1-content-container__true-content-container__content-container">
                        <span
                              class="dashboard-panel-1-content-container__true-content-container__content-container__address">
                              Endereço de Entrega
                        </span>
                        <div
                              class="dashboard-panel-1-content-container__true-content-container__content-container__info-container --red">
                              <p>
                                    <i>Cidade:</i>
                              </p>
                              <p>
                                    <i>Bairro:</i>
                              </p>
                              <p>
                                    <i>Rua:</i>
                              </p>
                              <p>
                                    <i>Número:</i>
                              </p>
                        </div>
                        <div
                              class="dashboard-panel-1-content-container__true-content-container__content-container__link-container --red">
                              <a href="">
                                    <i class="bi bi-map"></i>
                                    Abrir Pontos
                              </a>
                        </div>
                  </div>
            </div>
      </div>
</div>