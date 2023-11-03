(() => {
      window.document.querySelectorAll('div[default-panel-container]').forEach((container) => {
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