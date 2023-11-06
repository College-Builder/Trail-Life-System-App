(() => {
      const form = window.document.querySelector('form')
      const method = form.getAttribute("method")
      const action = form.getAttribute("action")
      const button = form.querySelector('button[type="submit"')

      form.addEventListener("submit", async (e) => {
            e.preventDefault()

            handleButtonLoading(true, button);

            const body = new FormData()

            form.querySelectorAll("input").forEach((input) => {
                  const name = input.getAttribute("name")
                  const value = input.value

                  body.append(name, value)
            })

            form.querySelectorAll("button[pseudo-select]").forEach((button) => {
                  const name = button.getAttribute("name")
                  const value = button.querySelector('option[selected]').getAttribute('value')
                  
                  body.append(name, value)
            })

            const a_auth = document.cookie.split('; ').find(cookie => cookie.startsWith('a_auth=')).split('=')[1];

            const req = await fetch(action, {
                  method,
                  headers: {
                        Authorization: `${a_auth}`
                  },
                  body,
            })

            handleButtonLoading(false, button);

            if (req.status === 200) {
                  console.log(req)
            } else if (req.status === 400) {
                  const res = await req.json()

                  console.log(res)
            } else if (req.status === 403) {
                  const res = await req.json()

                  spawnAlert(
                        'warning',
                        res['message']
                  );
            } else {
                  spawnAlert(
                        'warning',
                        'Oops, algo deu errado. Por favor, tente novamente mais tarde.',
                  );
            }
      })
})()