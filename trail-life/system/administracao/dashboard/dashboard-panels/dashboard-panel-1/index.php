<?php
$requestUrl = $_SERVER['REQUEST_URI'];

$blockedSubdirectory = '/system/administracao/dashboard/dashboard-panels';

if (strpos($requestUrl, $blockedSubdirectory) !== false) {
      http_response_code(404);
      exit;
}
?>
<div apply-hrz-padding class="default-panel-container">
      <div>
            <h1>Controle de Estatísticas</h1>
      </div>
      <div>
            <div class="dashboard-panel-1-content-container">
                  <div class="dashboard-panel-1-content-container__values-container">
                        <div>
                              <p>
                                    Total de Viagens
                              </p>
                              <p total-de-viagens></p>
                        </div>
                        <div>
                              <p>
                                    Viagens em Andamento
                              </p>
                              <p viagens-em-andamento></p>
                        </div>
                        <div>
                              <p>
                                    Viagens Fechadas
                              </p>
                              <p viagens-fechadas></p>
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
                        <button download-estatisticas-table-button class="default-icon-button">
                              <i class="bi bi-download"></i>
                              Download .csv
                        </button>
                  </div>
            </div>
      </div>
</div>
<script>
      (async () => {
            const authToken = document.cookie
                  .split('; ')
                  .find((cookie) => cookie.startsWith('a_auth='))
                  .split('=')[1];


            const req = await fetch("get/php/historico", {
                  method: 'GET',
                  headers: {
                        Authorization: `${authToken}`,
                  },
            });

            if (req.status === 500) {
                  spawnAlert(
                        'warning',
                        'Oops, algo deu errado. Por favor, tente novamente mais tarde.',
                  );

                  return;
            }

            const res = await req.json();

            if (req.status !== 200) {
                  spawnAlert('warning', req.message);

                  return;
            }

            //
            //
            //

            const totalDeViagensContainer = window.document.querySelector("[total-de-viagens]");
            totalDeViagensContainer.innerText = res.data.length === 1 ? res.data.length + " Viagem" : res.data.length + " Viagens";
      
            let viagensEmAndamento = 0;
            let viagensFechadas = 0;


            res.data.forEach(data => {
                  data.fechado ? viagensFechadas++ : viagensEmAndamento++;
            })

            const viagensEmAndamentoContainer = window.document.querySelector("[viagens-em-andamento]");
            viagensEmAndamentoContainer.innerText = viagensEmAndamento === 1 ? viagensEmAndamento + " Viagem" : viagensEmAndamento + " Viagens";

            const viagensFechadasContainer = window.document.querySelector("[viagens-fechadas]");
            viagensFechadasContainer.innerText = viagensFechadas === 1 ? viagensFechadas + " Viagem" : viagensFechadas + " Viagens";

            //
            //
            //

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

            const years = {}

            res.data.forEach(viagem => {
                  if (!viagem.fechado) {
                        return;
                  }

                  const template = viagem.fechado.split("-")
                  const year = template[0]
                  const month = template[1]

                  if (!years[year]) {
                        years[year] = {}
                  }

                  if (!years[year][month]) {
                        years[year][month] = 0;
                  }

                  years[year][month]++;
            })

            const datasets = []

            const yearsKeys = Object.keys(years)

            yearsKeys.forEach(year => {
                  const dataset = {
                        data: [],
                        label: `Viagens ${year}`
                  }

                  const monthsKeys = Object.keys(years[year])

                  monthsKeys.forEach(month => {
                        dataset.data.push(years[year][month])
                  })

                  datasets.push(dataset)
            })

            const data = {
                  labels,
                  datasets
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

            window.document.querySelector('button[download-estatisticas-table-button]').addEventListener("click", () => {
                  convertJsonToCsv(res.data, 'estatisticas-table')
            })

            function convertJsonToCsv(jsonData, fileName) {
                  const csvData = [];

                  const headers = Object.keys(jsonData[0]);
                  csvData.push(headers.join(','));

                  jsonData.forEach((item) => {
                        const values = headers.map((header) => item[header]);
                        csvData.push(values.join(','));
                  });

                  const csvString = csvData.join('\n');

                  const blob = new Blob([csvString], { type: 'text/csv' });

                  const link = document.createElement('a');
                  link.href = window.URL.createObjectURL(blob);
                  link.download = fileName + '.csv';

                  document.body.appendChild(link);
                  link.click();
                  document.body.removeChild(link);
            }
      })();
</script>
>