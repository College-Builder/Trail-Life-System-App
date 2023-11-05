<div apply-hrz-padding class="default-panel-container">
      <div>
            <h1>Controle Financeiro</h1>
      </div>
      <div>
            <div class="dashboard-panel-1-content-container">
                  <div class="dashboard-panel-1-content-container__values-container">
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
                  <div class="dashboard-panel-1-content-container__chart-container">
                        <div>
                              <div>
                                    <canvas chart></canvas>
                              </div>
                        </div>
                  </div>
                  <!---->
                  <!---->
                  <div class="download-csv-button-container">
                        <button class="default-icon-button">
                              <i class="bi bi-download"></i>
                              Download .csv
                        </button>
                  </div>
            </div>
      </div>
</div>
<script>
      (() => {
            labels = [
                  'jan',
                  'fev',
                  'mar',
                  'abr',
                  'mai',
                  'jun',
                  'jul',
                  'ago',
                  'set',
                  'out',
                  'nov',
                  'dez',
            ];

            const data = {
                  labels,
                  datasets: [
                        {
                              data: [
                                    1200, 1500, 1800, 2000, 1700, 2100, 1600, 1900, 2200, 2500, 2300,
                                    2400,
                              ],
                              label: 'Lucro 2022',
                        },
                        {
                              data: [
                                    1450, 1670, 1890, 1210, 1980, 1760, 1340, 1560, 1780, 1900, 1320, 1440
                              ],
                              label: 'Valor Bruto 2022',
                        },
                        {
                              data: [
                                    1800, 2100, 2200, 2500, 2300, 2400, 1900, 2000, 2300, 2600, 2400,
                                    2600,
                              ],
                              label: 'Lucro 2023',
                        },
                        {
                              data: [
                                    2200, 1950, 1670, 1880, 1750, 2100, 2330, 1920, 2470, 1980, 1810, 2150
                              ],
                              label: 'Valor Bruto 2023',
                        },
                  ],
            }

            const canvas = window.document
                  .querySelector('canvas[chart]')
                  .getContext('2d');

            let chart = new Chart(
                  canvas,
                  createConfig(window.innerWidth >= 800 ? 'bar' : 'pie', true),
            );

            let resizeTimer;

            window.addEventListener('resize', () => {
                  chart.destroy();

                  clearTimeout(resizeTimer);
                  resizeTimer = setTimeout(() => {

                        chart = new Chart(
                              canvas,
                              createConfig(window.innerWidth >= 800 ? 'bar' : 'pie', true),
                        );
                  }, 500);
            });

            function deepCopy(obj) {
                  if (obj === null || typeof obj !== 'object') {
                        return obj;
                  }

                  if (Array.isArray(obj)) {
                        const arrCopy = [];
                        for (let i = 0; i < obj.length; i++) {
                              arrCopy[i] = deepCopy(obj[i]);
                        }
                        return arrCopy;
                  }

                  const objCopy = {};
                  for (const key in obj) {
                        if (obj.hasOwnProperty(key)) {
                              objCopy[key] = deepCopy(obj[key]);
                        }
                  }

                  return objCopy;
            }

            function createConfig(type, animation) {
                  let delayed;

                  const config = {
                        type,
                        data,
                        options: {
                              responsive: true,
                        },
                  };

                  if (animation) {
                        config.options.animation = {
                              onComplete: () => {
                                    delayed = true;
                              },
                              delay: (context) => {
                                    let delay = 0;
                                    if (
                                          context.type === 'data' &&
                                          context.mode === 'default' &&
                                          !delayed
                                    ) {
                                          delay = context.dataIndex * 300 + context.datasetIndex * 100;
                                    }
                                    return delay;
                              },
                        };
                  }

                  return deepCopy(config);
            }
      })();
</script>