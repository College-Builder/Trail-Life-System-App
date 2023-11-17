<?php
$sql = 'SELECT id, filial, cliente FROM cargas WHERE motorista = ?;';
$params = array($motoristaId);
$result = $mysql->query($sql, $params);

$numCargas = $result->num_rows;

$row = mysqli_fetch_assoc($result);

$cargaId = $row['id'];
$cargaFilialId = $row['filial'];
$cargaClienteId = $row['cliente'];
?>
<?php
if ($numCargas !== 0) {
      $sql = 'SELECT estado, cidade, rua, numero FROM filiais WHERE id = ?;';
      $params = array($cargaFilialId);
      $result = $mysql->query($sql, $params);

      $row = mysqli_fetch_assoc($result);

      $filialEstado = $row['estado'];
      $filialCidade = $row['cidade'];
      $filialRua = $row['rua'];
      $filialNumero = $row['numero'];
}
?>
<?php
if ($numCargas !== 0) {
      $sql = 'SELECT empresa, estado, cidade, rua, numero FROM clientes WHERE id = ?;';
      $params = array($cargaClienteId);
      $result = $mysql->query($sql, $params);

      $row = mysqli_fetch_assoc($result);

      $clienteEmpresa = $row['empresa'];
      $clienteEstado = Cypher::decryptStringUsingAES256($row['estado'], $_ENV["CLIENTES_ESTADO_CYPHER_KEY"]);
      $clienteCidade = Cypher::decryptStringUsingAES256($row['cidade'], $_ENV["CLIENTES_CIDADE_CYPHER_KEY"]);
      $clienteRua = Cypher::decryptStringUsingAES256($row['rua'], $_ENV["CLIENTES_RUA_CYPHER_KEY"]);
      $clienteNumero = Cypher::decryptStringUsingAES256($row['numero'], $_ENV["CLIENTES_NUMERO_CYPHER_KEY"]);
}
?>
<div class="default-panel-container" apply-hrz-padding>
      <div class="dashboard-panel-1-content-container">
            <!---->
            <!---->
            <div style="<?php if ($numCargas !== 0) {
                  echo "display: none";
            } ?>" class="dashboard-panel-1-content-container__no-content-container">
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
            <div style="<?php if ($numCargas === 0) {
                  echo "display: none";
            } ?>" class="dashboard-panel-1-content-container__true-content-container">
                  <div class="dashboard-panel-1-content-container__true-content-container__content-container">
                        <span
                              class="dashboard-panel-1-content-container__true-content-container__content-container__id">
                              <?php echo "#" . $cargaId ?>
                        </span>
                        <div
                              class="dashboard-panel-1-content-container__true-content-container__content-container__info-container --yellow">
                              <p>
                                    <i>Código rastreio: </i>
                                    <?php echo $cargaId ?>
                              </p>
                              <p>
                                    <i>Retirar em: </i>
                                    <?php echo $filialCidade . "/" . $filialEstado . " - " . $filialRua . " nº " . $filialNumero ?>
                              </p>
                              <p>
                                    <i>Solicitante: </i>
                                    <?php echo $clienteEmpresa ?>
                              </p>
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
                                    <i>Estado:</i>
                                    <?php echo $clienteEstado ?>
                              </p>
                              <p>
                                    <i>Cidade:</i>
                                    <?php echo $clienteCidade ?>
                              </p>
                              <p>
                                    <i>Rua:</i>
                                    <?php echo $clienteRua ?>
                              </p>
                              <p>
                                    <i>Número:</i>
                                    <?php echo $clienteNumero ?>
                              </p>
                        </div>
                  </div>
            </div>
      </div>
</div>
