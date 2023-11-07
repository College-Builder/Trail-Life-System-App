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

spawnConfirmIsFirstTime = true
function spawnConfirm(table, {title, iconClass, callback}) {
	const confirmContainer = window.document.querySelector("div[default-confirm-container]")
	const contentContainer = confirmContainer.querySelector("div[content-container]")

      confirmContainer.querySelector("i[default-confirm-container__icon]").classList.add(iconClass)
      confirmContainer.querySelector("i[default-confirm-container__title]").innerText = title

      while (contentContainer.firstChild) {
            contentContainer.removeChild(contentContainer.firstChild)
      }

	contentContainer.append(table)

	confirmContainer.classList.add("--on")

	if (!spawnConfirmIsFirstTime) {
		return
	}

	spawnConfirmIsFirstTime = false

      const cancelButton = window.document.querySelector("button[default-confirm-container__cancel-button]")

	cancelButton.addEventListener("click", () => closeConfirmContainer())

      const confirmButton = window.document.querySelector("button[default-confirm-container__confirm-button]")

      confirmButton.addEventListener("click", async () => {
            handleButtonLoading(true, confirmButton)
            await callback(() => closeConfirmContainer())
            handleButtonLoading(false, confirmButton)
      })

      function closeConfirmContainer() {
            confirmContainer.classList.remove("--on")
      }
}