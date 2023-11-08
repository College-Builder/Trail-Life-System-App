<div class="default-panel-container">
      <div apply-hrz-padding>
            <h1>Controle de Admins</h1>
      </div>
      <div>
            <div class="dashboard-panel-2-content-container">
                  <div apply-hrz-padding class="default-panel-container__table-actions-container">
                        <div class="pill-button-container">
                              <a class="--red-button" href="/system/administracao/dashboard/add/admin/">
                                    + Admin
                              </a>
                        </div>
                        <div class="default-panel-container__table-actions-container__inputs-container">
                              <input admins-table-search-input class="pill-input" type="text" placeholder="Procurar">
                        </div>
                  </div>
                  <!---->
                  <!---->
                  <div click-scroll class="default-panel-container__table-container">
                        <div apply-hrz-padding>
                              <table admins-table>
                                    <thead>
                                          <tr>
                                                <th>
                                                      Permissão
                                                </th>
                                                <th>
                                                      Nome
                                                </th>
                                                <th>
                                                      Email
                                                </th>
                                                <th>
                                                      <button>
                                                            <i class="bi bi-trash"></i>
                                                      </button>
                                                </th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          <template admins-table__tamplate>
                                                <tr>
                                                      <template>
                                                            <td></td>
                                                      </template>
                                                      <td>
                                                            <div>
                                                                  <a  admins-table__tamplate__update-link>
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
                        <button class="default-icon-button">
                              <i class="bi bi-download"></i>
                              Download .csv
                        </button>
                  </div>
            </div>
      </div>
</div>