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