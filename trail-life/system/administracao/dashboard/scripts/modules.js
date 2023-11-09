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
	window.document.querySelectorAll('.--show-error').forEach((div) => {
		div.classList.remove('--show-error');
	});

	const input =
		window.document.querySelector(`input[name='${label}']`) ||
		window.document.querySelector(`button[name='${label}']`);

	const container = input.parentElement.parentElement;

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
	const optionsContainer = button.querySelector(
		'div[pseudo-select__options-container]',
	);
	const options = optionsContainer.querySelectorAll('option');

	if (options.length === 0) {
		return;
	}

	const selectValue = button.getAttribute('select-value');
	let selectOption;

	for (let c = 0; c < options.length; c++) {
		if (options[c].hasAttribute('unselectable')) {
			continue;
		} else {
			selectOption = options[c];

			break;
		}
	}

	optionsContainer.querySelectorAll('option[unselectable').forEach((option) => {
		option.classList.add('--unselectable');
	});

	if (!selectOption) {
		selectOption = options[0];
	}

	if (selectValue) {
		selectOption = button.querySelector(`option[value="${selectValue}"]`);
	}

	selectOption.setAttribute('selected', '');
	button.prepend(selectOption);

	const originalOptionsContainerHeight =
		getComputedStyle(optionsContainer).height;

	if (Number(originalOptionsContainerHeight.replace('px', '')) > 200) {
		button.classList.add('--scroll');
	}

	button.classList.add('--off');
	optionsContainer.style.height = originalOptionsContainerHeight;

	let justFocused = false;

	button.addEventListener('focus', () => {
		optionsContainer.style.visibility = 'hidden';

		button.classList.add('--on');

		if (isElementPartiallyHidden(optionsContainer)) {
			button.classList.add('--top');
		}

		optionsContainer.style.visibility = 'visible';

		justFocused = true;
	});

	button.addEventListener('click', () => {
		if (justFocused) {
			justFocused = false;

			return;
		}

		button.blur();
	});

	button.addEventListener('blur', () => {
		button.classList.remove('--on');
		button.classList.remove('--top');
	});

	options.forEach((option) => {
		option.addEventListener('click', () => {
			const newValue = option.getAttribute('value');
			const newInnerText = option.innerText;

			const selected = button.querySelector('option[selected]');

			const oldValue = selected.getAttribute('value');
			const oldInnerText = selected.innerText;

			option.setAttribute('value', oldValue);
			option.innerText = oldInnerText;

			selected.innerText = newInnerText;
			selected.setAttribute('value', newValue);

			button.blur();
		});
	});

	function isElementPartiallyHidden(element) {
		const elementRect = element.getBoundingClientRect();
		const viewportHeight =
			window.innerHeight || document.documentElement.clientHeight;
		const scrollY = window.scrollY || window.pageYOffset;

		return elementRect.top < 0 || elementRect.bottom > viewportHeight;
	}
}

function setPlateBrInputProperties(input) {
	input.addEventListener('input', (e) => {
		let value = input.value.toUpperCase();

		if (value.length === 0) {
			input.value = '';
		} else if (value.length <= 3) {
			if (isNaN(value.substr(value.length - 1))) {
				input.value = value;

				return;
			}

			input.value = value.substr(0, value.length - 1);
		} else {
			if (!isNaN(value.substr(value.length - 1))) {
				input.value = value.substr(0, 8);

				return;
			}

			input.value = value.substr(0, value.length - 1);
		}
	});
}

function setCnpjInputProperties(input) {
	input.addEventListener('input', () => {
		let value = String(input.value.replace(/\D/g, ''));

		if (value.length === 0) {
			input.value = '';
		} else if (value.length <= 2) {
			input.value = `${value}`;
		} else if (value.length <= 5) {
			input.value = `${value.slice(0, 2)}.${value.slice(2, value.length)}`;
		} else if (value.length <= 8) {
			input.value = `${value.slice(0, 2)}.${value.slice(2, 5)}.${value.slice(
				5,
				8,
			)}`;
		} else if (value.length <= 12) {
			input.value = `${value.slice(0, 2)}.${value.slice(2, 5)}.${value.slice(
				5,
				8,
			)}/${value.slice(8, 12)}`;
		} else {
			input.value = `${value.slice(0, 2)}.${value.slice(2, 5)}.${value.slice(
				5,
				8,
			)}/${value.slice(8, 12)}-${value.slice(12, 14)}`;
		}
	});
}

function setCpfInputProperties(input) {
	input.addEventListener('input', () => {
		let value = String(input.value.replace(/\D/g, ''));

		if (value.length === 0) {
			input.value = '';
		} else if (value.length <= 3) {
			input.value = `${value}`;
		} else if (value.length <= 6) {
			input.value = `${value.slice(0, 3)}.${value.slice(3, value.length)}`;
		} else if (value.length <= 9) {
			input.value = `${value.slice(0, 3)}.${value.slice(3, 6)}.${value.slice(
				6,
				value.length,
			)}`;
		} else {
			input.value = `${value.slice(0, 3)}.${value.slice(3, 6)}.${value.slice(
				6,
				9,
			)}-${value.slice(9, 11)}`;
		}
	});
}

function setRgInputProperties(input) {
	input.addEventListener('input', () => {
		const lastChar = input.value.replace('-', '').substr(10, 10).substr(0, 1);
		let value = String(input.value.replace(/\D/g, ''));

		if (value.length > 7 && isNaN(lastChar)) {
			input.value = `${value.slice(0, 2)}.${value.slice(2, 5)}.${value.slice(
				5,
				8,
			)}-${lastChar}`;

			return;
		}

		if (value.length === 0) {
			input.value = '';
		} else if (value.length <= 2) {
			input.value = `${value}`;
		} else if (value.length <= 5) {
			input.value = `${value.slice(0, 2)}.${value.slice(2, value.length)}`;
		} else if (value.length <= 8) {
			input.value = `${value.slice(0, 2)}.${value.slice(2, 5)}.${value.slice(
				5,
				value.length,
			)}`;
		} else {
			input.value = `${value.slice(0, 2)}.${value.slice(2, 5)}.${value.slice(
				5,
				8,
			)}-${lastChar}`;
		}
	});
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

spawnConfirmIsFirstTime = true;
function spawnConfirm(content, { title, iconClass, callback }) {
	const confirmContainer = window.document.querySelector(
		'div[default-confirm-container]',
	);
	const contentContainer = confirmContainer.querySelector(
		'div[content-container]',
	);

	confirmContainer
		.querySelector('i[default-confirm-container__icon]')
		.classList.add(iconClass);
	confirmContainer.querySelector(
		'i[default-confirm-container__title]',
	).innerText = title;

	while (contentContainer.firstChild) {
		contentContainer.removeChild(contentContainer.firstChild);
	}

	if (content) {
		contentContainer.append(content);
	}

	confirmContainer.classList.add('--on');

	const cancelButton = window.document.querySelector(
		'button[default-confirm-container__cancel-button]',
	);
	const confirmButton = window.document.querySelector(
		'button[default-confirm-container__confirm-button]',
	);

	if (spawnConfirmIsFirstTime) {
		spawnConfirmIsFirstTime = false;

		cancelButton.addEventListener('click', () => closeConfirmContainer());
	}

	confirmButton.removeEventListener('click', null);

	confirmButton.addEventListener('click', async () => {
		handleButtonLoading(true, confirmButton);
		await callback(() => closeConfirmContainer());
		handleButtonLoading(false, confirmButton);
	});

	function closeConfirmContainer() {
		confirmContainer.classList.remove('--on');
	}
}
