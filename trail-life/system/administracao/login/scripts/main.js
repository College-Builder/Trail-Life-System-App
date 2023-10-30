const form = window.document.querySelector('form');
const method = form.getAttribute('method');
const action = form.getAttribute('action');
const button = form.querySelector('button[type="submit"]');

form.addEventListener('submit', async (e) => {
	e.preventDefault();

	handleButtonLoading(true, button);

	const form = new FormData();

	form.append('usuario', e.target.elements.usuario.value);
	form.append('senha', e.target.elements.senha.value);

	const req = await fetch(action, {
		method,
		body: form,
	});

	handleButtonLoading(false, button);

	if (req.status === 200) {
		window.location.href =
			'http://localhost/trail-life/system/administracao/dashboard/';
	} else if (req.status === 400) {
		const { label, message } = await req.json();

		handleFormErrorMessageResponse(label, message);
	} else {
		spawnAlert(
			'warning',
			'Oops, algo deu errado. Por favor, tente novamente mais tarde.',
		);
	}
});
