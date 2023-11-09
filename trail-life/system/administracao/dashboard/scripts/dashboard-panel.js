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
      const titles = ['motoristas', 'clientes', 'admins']

      titles.forEach((title) => {
            setTableAttributes(title)
      })
})();

async function setTableAttributes(title) {
      const authToken = document.cookie.split('; ').find(cookie => cookie.startsWith('a_auth=')).split('=')[1];

      const table = window.document.querySelector(`table[${title}-table]`)
      const thead = table.querySelector('thead')
      const tbody = table.querySelector('tbody')

      const getAction = `/system/administracao/dashboard/get/php/${title}/index.php`
      const updateAction = `/system/administracao/dashboard/update/${title.substring(0, title.length - 1)}`
      const delAction = `/system/administracao/dashboard/delete/php/${title}/index.php`

      const searchInput = window.document.querySelector(`input[${title}-table-search-input]`)
      const downloadTableButton = window.document.querySelector(`button[download-${title}-table-button]`)

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

      thead.querySelector("button").addEventListener("click", () => {
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

      downloadTableButton.addEventListener("click", () => {
            const columns = []
            const csv = []

            thead.querySelectorAll("th[value]").forEach((th) => {
                  columns.push(th.getAttribute('value'))
            })

            tbody.querySelectorAll("tr").forEach(tr => {
                  if (tr.style.display === 'none') {
                        return
                  }

                  const row = {}

                  tr.querySelectorAll("td[value]").forEach((td, index) => {
                        row[columns[index]] = td.getAttribute('value')
                  })

                  csv.push(row)
            })

            convertJsonToCsv(csv, `${title}-table`)
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

            if (res.data.length === 0) {
                  table.style.display = 'none'
                  downloadTableButton.parentElement.style.display = "none"

                  return
            }

            const isTheadRendered = thead.querySelectorAll("th").length > 1

            if (!isTheadRendered) {
                  const tableHeadTemplate = thead.querySelectorAll('template')[0]

                  Object.keys(res.data[0]).forEach(key => {
                        if (key === 'id') {
                              return
                        }

                        const usableTableHeadTemplate = tableHeadTemplate.cloneNode(true).content.children[0]

                        usableTableHeadTemplate.innerText = key
                        usableTableHeadTemplate.setAttribute("value", key)

                        tableHeadTemplate.parentElement.prepend(usableTableHeadTemplate)
                  })
            } 

            const tableBodyTemplate = tbody.querySelectorAll('template')[0]

            tbody.querySelectorAll("tr").forEach(tr => {
                  tr.remove()
            })

            res.data.forEach((user) => {
                  const usableTableBodyTemplate = tableBodyTemplate.cloneNode(true).content.children[0]
                  const itemTemplate = usableTableBodyTemplate.querySelector("template")

                  usableTableBodyTemplate.querySelector("a").setAttribute("href", `${updateAction}?id=${user.id}`)

                  Object.keys(user).forEach((key) => {
                        if (key === 'id') {
                              usableTableBodyTemplate.setAttribute("identifier", user[key])

                              return
                        }


                        if (!usableTableBodyTemplate.getAttribute('content')) {
                              usableTableBodyTemplate.setAttribute('content', `${user[key].toLowerCase()}`)
                        } else {
                              const rowContent = usableTableBodyTemplate.getAttribute('content')
                              usableTableBodyTemplate.setAttribute('content', `${rowContent};; ${user[key].toLowerCase()}`)
                        }

                        const usableItemTemplate = itemTemplate.cloneNode(true).content.children[0]

                        usableItemTemplate.innerText = user[key]
                        usableItemTemplate.setAttribute("value", user[key])

                        usableTableBodyTemplate.prepend(usableItemTemplate)
                  })

                  tableBodyTemplate.parentElement.append(usableTableBodyTemplate)
            })
      }

      function convertJsonToCsv(jsonData, fileName) {
            const csvData = [];
            
            const headers = Object.keys(jsonData[0]);
            csvData.push(headers.join(','));

            jsonData.forEach(item => {
                  const values = headers.map(header => item[header]);
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
}