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
<script>
      (() => {

      })();
</script>
<script>
      (async () => {
            const authToken = document.cookie.split('; ').find(cookie => cookie.startsWith('a_auth=')).split('=')[1];
            const getAction = "/system/administracao/dashboard/get/php/admins/index.php"
            const delAction = "/system/administracao/dashboard/delete/php/admins/index.php"

            const searchInput = window.document.querySelector('input[admins-table-search-input]')

            const table = window.document.querySelector('table[admins-table]')
            const tbody = table.querySelector('tbody')

            const deleteItemsButton = table.querySelector('thead').querySelector("button")

            await renderTable()

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

            deleteItemsButton.addEventListener("click", () => {
                  const tableClone = table.cloneNode(true)
                  let numberOfRowToDelete = 0

                  tableClone.querySelector("thead").querySelector("button").remove()

                  tableClone.querySelector("tbody").querySelectorAll("tr").forEach((tr) => {
                        const checkbox = tr.querySelector('input[type="checkbox"]')

                        if (checkbox.checked) {
                              checkbox.parentElement.querySelector("a").remove()

                              numberOfRowToDelete++

                              return
                        }

                        tr.remove()
                  })

                  if (!numberOfRowToDelete) {
                        spawnAlert("warning", "Por favor, marque os itens que deseja excluir.")

                        return
                  }

                  spawnConfirm(tableClone, {
                        title: numberOfRowToDelete === 1 ? "Excluir Admin" : "Excluir Admins",
                        iconClass: "bi-trash",
                        callback: async (closeConfirmContainer) => {
                              let body = new FormData()

                              tableClone.querySelector("tbody").querySelectorAll("tr").forEach(tr => {
                                    const checkbox = tr.querySelector('input[type="checkbox"]')

                                    if (checkbox.checked) {
                                          body.append('ids', tr.getAttribute("identifier"))
                                    }
                              })

                              const req = await fetch(delAction, {
                                    method: "POST",
                                    headers: {
                                          Authorization: `${authToken}`
                                    },
                                    body,
                              })

                              if (req.status === 500) {
                                    spawnAlert(
                                          'warning',
                                          'Oops, algo deu errado. Por favor, tente novamente mais tarde.'
                                    );

                                    return
                              } 

                              if (req.status !== 200) {
                                    const res = await req.json()

                                    spawnAlert(
                                          'warning',
                                          res.message, 
                                    );

                                    return
                              } 

                              closeConfirmContainer()

                              spawnAlert(
                                    'success',
                                    'Itens deletados com successo.'
                              );

                              renderTable()
                        }
                  })
            })

            async function renderTable() {
                  const req = await fetch(getAction, {
                        headers: {
                              Authorization: `${authToken}`
                        }
                  })

                  if (req.status === 403) {
                        window.location.reload();

                        return;
                  }

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

                  const tableTemplate = tbody.querySelectorAll('template')[0]

                  tbody.querySelectorAll("tr").forEach(tr => {
                        tr.remove()
                  })

                  res.data.forEach((user) => {
                        const usableTableTemplate = tableTemplate.cloneNode(true).content.children[0]
                        const itemTemplate = usableTableTemplate.querySelector("template")

                        usableTableTemplate.querySelector("a[admins-table__tamplate__update-link]").setAttribute("href", `/system/administracao/dashboard/update/admin?id=${user.id}`)

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