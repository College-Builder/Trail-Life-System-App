window.document.querySelectorAll('input[type="password"]').forEach((input) => {
	setPasswordButtonProperties(input);
});

window.document.querySelectorAll('button[pseudo-select').forEach((button) => {
	setPseudoSelectProperties(button)
});

window.document
	.querySelectorAll('input[pseudo-type="phone"]')
	.forEach((input) => {
		setPhoneInputProperties(input);
	});
