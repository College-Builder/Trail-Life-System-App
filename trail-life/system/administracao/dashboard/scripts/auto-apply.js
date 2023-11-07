window.document.querySelectorAll('button[pseudo-select').forEach((button) => {
	setPseudoSelectProperties(button)
});

window.document.querySelectorAll('input[type="password"]').forEach((input) => {
	setPasswordButtonProperties(input);
});

window.document.querySelectorAll('input[pseudo-type="cpf"]').forEach((input) => {
	setCpfInputProperties(input)
});

window.document.querySelectorAll('input[pseudo-type="rg"]').forEach((input) => {
	setRgInputProperties(input)
});

window.document.querySelectorAll('input[pseudo-type="plate-br"]').forEach((input) => {
	setPlateBrInputProperties(input)
});

window.document
	.querySelectorAll('input[pseudo-type="phone"]')
	.forEach((input) => {
		setPhoneInputProperties(input);
	});
