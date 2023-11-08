(() => {
      window.document.querySelectorAll('[apply-hrz-padding]').forEach((container) => {
            handleWidth(container)

            window.addEventListener("resize", () => {
                  handleWidth(container)
            })
      })
      

      function handleWidth(container) {
            let defaultSizeClass = 'default-hrz-padding';
            let smallSizeClass = 'small-hrz-padding';

            if (window.innerWidth >= 1200) {
                  container.classList.remove(defaultSizeClass)
                  container.classList.add(smallSizeClass)
            } else {
                  container.classList.add(defaultSizeClass)
                  container.classList.remove(smallSizeClass)
            }
      }
})()

window.document
.querySelectorAll('div[click-scroll]')
.forEach((sliderContainer) => {
      let isDown = false;
      let startX;
      let position;
      let scrollLeft;

      sliderContainer.addEventListener('touchmove', () => {
            isDown = true;
      });
      sliderContainer.addEventListener('touchend', () => {
            isDown = false;
      });
      sliderContainer.addEventListener('mousedown', (e) => {
            isDown = true;
            sliderContainer.classList.add('active');
            startX = e.pageX - sliderContainer.offsetLeft;
            scrollLeft = sliderContainer.scrollLeft;
      });
      sliderContainer.addEventListener('mouseleave', () => {
            isDown = false;
            sliderContainer.classList.remove('active');
      });
      sliderContainer.addEventListener('mouseup', () => {
            isDown = false;
            sliderContainer.classList.remove('active');
      });
      sliderContainer.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - sliderContainer.offsetLeft;
            const walk = x - startX;
            sliderContainer.scrollLeft = scrollLeft - walk;
            position = sliderContainer.scrollLeft;
      });
});

(() => {
      const urlParams = new URLSearchParams(window.location.search);
      const alertMessage = urlParams.get('alert');
      const timestamp = urlParams.get('timestamp');

      if (!alertMessage || !timestamp) {
            return
      }

      const dataAtual = new Date();
      const dataAntiga = new Date(timestamp);

      const diferencaEmMilissegundos = dataAtual - dataAntiga;
      const diferencaEmSegundos = diferencaEmMilissegundos / 1000;

      if (diferencaEmSegundos <= 10) {
            spawnAlert(
                  'success',
                  alertMessage.replace(/%20/g, " "),
            );
      }
})();

(async () => {
      const authToken = document.cookie.split('; ').find(cookie => cookie.startsWith('a_auth=')).split('=')[1];
      const getAction = "/system/administracao/dashboard/get/php/admins/index.php"
      const delAction = "/system/administracao/dashboard/delete/php/admins/index.php"
      const searchInput = window.document.querySelector('input[admins-table-search-input]')
      const table = window.document.querySelector('table[admins-table]')
      const tbody = table.querySelector('tbody')
      const deleteItemsButton = table.querySelector('thead').querySelector("button")

      setTableAttributes(authToken, getAction, delAction, searchInput, table, tbody, deleteItemsButton)
})();

async function setTableAttributes(authToken, getAction, delAction, searchInput, table, tbody, deleteItemsButton) {
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
                        let body = {
                              ids: []
                        }

                        tableClone.querySelector("tbody").querySelectorAll("tr").forEach(tr => {
                              const checkbox = tr.querySelector('input[type="checkbox"]')

                              if (checkbox.checked) {
                                    body.ids.push(tr.getAttribute("identifier"))
                              }
                        })

                        const req = await fetch(delAction, {
                              method: "DELETE",
                              headers: {
                                    Authorization: `${authToken}`,
                              },
                              body: JSON.stringify(body),
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
}