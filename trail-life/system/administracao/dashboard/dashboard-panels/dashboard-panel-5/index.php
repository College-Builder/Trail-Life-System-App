<div class="default-panel-container">
      <div apply-hrz-padding>
            <h1>Controle de Admins</h1>
      </div>
      <div>
            <div class="dashboard-panel-2-content-container">
                  <div apply-hrz-padding class="default-panel-container__table-actions-container">
                        <div class="pill-icon-button-container">
                              <a href="/system/administracao/dashboard/add/admin/">
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
                              <table>
                                    <thead>
                                          <tr>
                                                <th>
                                                      Nome
                                                </th>
                                                <th>
                                                      Email
                                                </th>
                                                <th>
                                                      Permissão
                                                </th>
                                                <th>
                                                      <button admins-table__delete-item>
                                                            <i class="bi bi-trash"></i>
                                                      </button>
                                                </th>
                                          </tr>
                                    </thead>
                                    <tbody admins-table>
                                          <template admins-table__tamplate>
                                                <tr>
                                                      <template>
                                                            <td></td>
                                                      </template>
                                                      <td>
                                                            <div>
                                                                  <a href="" target="_blank">
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
<script>
      (() => {
            const authToken = document.cookie.split('; ').find(cookie => cookie.startsWith('a_auth=')).split('=')[1];
            const action = "/system/administracao/dashboard/get/php/admins/index.php"
            const tbody = window.document.querySelector('tbody[admins-table]')
            const searchInput = window.document.querySelector('input[admins-table-search-input]')

            renderTable()

            searchInput.addEventListener("input", () => {
                  tbody.querySelectorAll("tr").forEach((tr) => {
                        const content = tr.getAttribute("content")

                        if (content.includes(searchInput.value.toLowerCase())) {
                              tr.style.display = "table-row"
                        } else {
                              tr.style.display = "none"
                        }
                  })
            })

            async function renderTable() {
                  const req = await fetch(action, {
                        headers: {
                              Authorization: `${authToken}`
                        }
                  })

                  if (req.status === 500) {
                        spawnAlert(
                              'warning',
                              'Oops, algo deu errado. Por favor, tente novamente mais tarde.'
                        );

                        return;
                  }

                  const res = await req.json()

                  if (req.status !== 200) {
                        spawnAlert(
                              'warning',
                              req.message
                        );

                        return;
                  }

                  tbody.querySelectorAll("tr").forEach((tr) => {
                        tr.remove()
                  })

                  const tableTemplate = tbody.querySelectorAll('template')[0]

                  res.data.forEach((user) => {
                        const usableTableTemplate = tableTemplate.cloneNode(true).content.children[0]
                        const itemTemplate = usableTableTemplate.querySelector("template")

                        Object.keys(user).forEach((key) => {
                              if (key === 'id') {
                                    usableTableTemplate.setAttribute("identifier", user[key])

                                    return
                              } 
                              

                              if (!usableTableTemplate.getAttribute('content')) {
                                    usableTableTemplate.setAttribute('content', `${user[key].toLowerCase()}`)
                              } else {
                                    const rowContent = usableTableTemplate.getAttribute('content')
                                    usableTableTemplate.setAttribute('content', `${rowContent};; ${user[key].toLowerCase()}`)
                              }

                              const usableItemTemplate = itemTemplate.cloneNode(true).content.children[0]

                              usableItemTemplate.innerText = user[key] 
                              
                              usableTableTemplate.prepend(usableItemTemplate)
                        })

                        tableTemplate.parentElement.append(usableTableTemplate)
                  })
            }
      })()
</script>