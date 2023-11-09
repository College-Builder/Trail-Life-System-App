<div class="default-panel-container">
      <div apply-hrz-padding>
            <h1>Controle de Cargas</h1>
      </div>
      <div>
            <div class="dashboard-panel-2-content-container">
                  <div apply-hrz-padding class="default-panel-container__table-actions-container">
                        <div class="pill-button-container">
                              <a add-carga-link class="--red-button"></a>
                        </div>
                        <div class="default-panel-container__table-actions-container__inputs-container">
                              <input cargas-table-search-input class="pill-input" type="text" placeholder="Procurar">
                        </div>
                  </div>
                  <!---->
                  <!---->
                  <div click-scroll class="default-panel-container__table-container">
                        <div apply-hrz-padding>
                              <table cargas-table>
                                    <thead>
                                          <tr>
                                                <template>
                                                      <th></th>
                                                </template>
                                                <th>
                                                      <button>
                                                            <i class="bi bi-trash"></i>
                                                      </button>
                                                </th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          <template>
                                                <tr>
                                                      <template>
                                                            <td></td>
                                                      </template>
                                                      <td>
                                                            <div>
                                                                  <a>
                                                                        <i class="bi bi-pencil-square"></i>
                                                                  </a>
                                                                  <input type="checkbox">
                                                            </div>
                                                      </td>
                                                </tr>
                                          </template>
                                    </tbody>
                              </table>
                        </div>
                  </div>
                  <!---->
                  <!---->
                  <div apply-hrz-padding class="download-csv-button-container">
                        <button download-cargas-table-button class="default-icon-button">
                              <i class="bi bi-download"></i>
                              Download .csv
                        </button>
                  </div>
            </div>
      </div>
</div>