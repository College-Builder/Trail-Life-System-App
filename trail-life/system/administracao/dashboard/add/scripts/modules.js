function handleButtonLoading(loading, button) {
	if (loading) {
		button.classList.add('--pre-loading');

		setTimeout(() => {
			if (button.classList.contains('--pre-loading')) {
				button.classList.remove('--pre-loading');
				button.classList.add('--loading');
			}
		}, 500);
	} else {
		button.classList.remove('--pre-loading');
		button.classList.remove('--loading');
	}
}

function handleFormErrorMessageResponse(label, message) {
	window.document.querySelectorAll('div[default-input]').forEach((div) => {
		div.classList.remove('--show-error');
	});

	const container = window.document.querySelector(`input[name='${label}']`)
		.parentElement.parentElement;

	container.classList.add('--show-error');
	container.querySelector('i[error-message]').innerText = message;
}

function setPasswordButtonProperties(input) {
	const parent = input.parentNode;
	const button = parent.querySelector('button');
	const icon = button.querySelector('i');
	const iconClasses = ['bi-eye', 'bi-eye-slash'];
	let showing = false;

	button.addEventListener('click', () => {
		input.setAttribute('type', showing ? 'password' : 'text');
		icon.classList.remove(iconClasses[showing ? 1 : 0]);
		icon.classList.add(iconClasses[showing ? 0 : 1]);
		showing = !showing;
	});
}

function setPseudoSelectProperties(button) {
	const options = button.querySelectorAll("option")
	const optionsContainer = button.querySelector("div")

	options[0].setAttribute('selected', '')

	button.append(options[0])

	button.addEventListener("focus", () => {
		optionsContainer.classList.add("--on")
	})

	button.addEventListener("blur", () => {
		optionsContainer.classList.remove("--on")
	})

	options.forEach(option => {
		option.addEventListener("click", () => {
			const newValue = option.getAttribute('value')
			const newInnerText = option.innerText

			const selected = button.querySelector('option[selected]')

			const oldValue = selected.getAttribute('value')
			const oldInnerText = selected.innerText

			option.setAttribute("value", oldValue)
			option.innerText = oldInnerText

			selected.innerText = newInnerText
			selected.setAttribute('value', newValue)

			button.blur()
		})
	})
}

function setPhoneInputProperties(input) {
	input.addEventListener('keydown', (event) => {
		const input = event.target;
		let value = String(input.value.replace(/\D/g, ''));

		if (event.key === 'Backspace') {
			if (value.length === 4) {
				input.value = `+${value.slice(0, 2)} (${value.slice(2, 3)})`;
			}

			if (value.length === 3) {
				input.value = value.slice(0, 3);
			}
		}
	});

	input.addEventListener('input', () => {
		let value = String(input.value.replace(/\D/g, ''));

		if (value.length === 0) {
			input.value = '';
		} else if (value.length <= 2) {
			input.value = `+${value}`;
		} else if (value.length === 3) {
			input.value = `+${value.slice(0, 2)} (${value.charAt(2)})`;
		} else if (value.length <= 4) {
			input.value = `+${value.slice(0, 2)} (${value.slice(2, 4)})`;
		} else if (value.length <= 9) {
			input.value = `+${value.slice(0, 2)} (${value.slice(2, 4)}) ${value.slice(
				4,
				9,
			)}`;
		} else {
			input.value = `+${value.slice(0, 2)} (${value.slice(2, 4)}) ${value.slice(
				4,
				9,
			)}-${value.slice(9, 13)}`;
		}
	});
}

function spawnAlert(type, text) {
	const templateParent = window.document.querySelector(
		'div[default-alerts-container]',
	);

	const template = templateParent.querySelector('template').cloneNode(true)
		.content.children[0];

	const icons = {
		success: 'bi-check-circle',
		warning: 'bi-exclamation-octagon',
	};

	template.classList.add(`--${type}`);

	template
		.querySelector('i[default-alert-container__icon]')
		.classList.add(icons[type]);

	template.querySelector('i[default-alert-container__message]').innerText =
		text;

	templateParent.append(template);

	template.style.height = window
		.getComputedStyle(template)
		.getPropertyValue('height');

	setTimeout(() => {
		template.classList.add('--on');

		setTimeout(() => {
			template.classList.remove('--on');

			setTimeout(() => {
				template.classList.add('--remove');

				setTimeout(() => {
					template.remove();
				}, 700);
			}, 700);
		}, 6000);
	}, 1000);
}
