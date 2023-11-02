(() => {
      const defaultPanelContainer = window.document.querySelector('div[default-panel-container]')
      
      handleWidth()

      window.addEventListener("resize", () => {
            handleWidth()
      })

      function handleWidth() {
            let defaultSizeClass = 'default-hrz-padding';
            let smallSizeClass = 'small-hrz-padding';

            if (window.innerWidth >= 1200) {
                  defaultPanelContainer.classList.remove(defaultSizeClass)
                  defaultPanelContainer.classList.add(smallSizeClass)
            } else {
                  defaultPanelContainer.classList.add(defaultSizeClass)
                  defaultPanelContainer.classList.remove(smallSizeClass)
            }
      }
})()