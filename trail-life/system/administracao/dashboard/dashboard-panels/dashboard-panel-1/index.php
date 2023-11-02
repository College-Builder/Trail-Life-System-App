<script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!---->
<!---->
<link rel="stylesheet"
      href="/system/administracao/dashboard/dashboard-panels/dashboard-panel-1/styles/dashboard-panel/dashboard-panel.css?v=<?php echo time(); ?>">
<link rel="stylesheet"
      href="/system/administracao/dashboard/dashboard-panels/dashboard-panel-1/styles/dashboard-panel-1/dashboard-panel-1.css?v=<?php echo time(); ?>">
<!---->
<!---->
<script defer
      src="/system/administracao/dashboard/dashboard-panels/dashboard-panel-1/scripts/dashboard-panel.js?v=1.0"></script>
<script defer
      src="/system/administracao/dashboard/dashboard-panels/dashboard-panel-1/scripts/dashboard-panel-1.js?v=1.0"></script>
<!---->
<!---->
<div default-panel-container class="default-panel-container" class="default-hrz-padding">
      <div>
            <h1>Hello World</h1>
      </div>
      <div>
            <div class="panel-content">
                  <div class="panel-content__values-container">
                        <div>
                              <p>
                                    Valor Bruto Arrecadado
                              </p>
                              <p>
                                    R$3.420.800
                              </p>
                        </div>
                        <div>
                              <p>
                                    Valor do Lucro
                              </p>
                              <p>
                                    R$3.420.800
                              </p>
                        </div>
                        <div>
                              <p>
                                    Valor de Custo
                              </p>
                              <p>
                                    R$300.123
                              </p>
                        </div>
                  </div>
                  <!---->
                  <!---->
                  <div class="panel-content__chart-container">
                        <div>
                              <div>
                                    <canvas chart></canvas>
                              </div>
                        </div>
                  </div>
                  <!---->
                  <!---->
                  <button class="panel-content__download-csv-button --default-text-hover-animation">
                        <i class="bi bi-download"></i>
                        Download .csv
                  </button>
            </div>
      </div>
</div>