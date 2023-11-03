(() => {
	const asideMenuContainer = window.document.querySelector(
		'div[aside-menu-container]',
	);

	window.document
		.querySelector('button[open-aside-menu-button]')
		.addEventListener('click', () => {
			asideMenuContainer.classList.add('--on');
		});

	asideMenuContainer
		.querySelectorAll('button[aside-menu-container__option]')
		.forEach((button) => {
			button.addEventListener('click', () => {
				asideMenuContainer.classList.remove('--on');
			});
		});

	window.document
		.querySelector('button[close-aside-menu-button]')
		.addEventListener('click', () => {
			asideMenuContainer.classList.remove('--on');
		});
})();

(() => {
	const asideMenuTemplate = window.document
		.querySelector('aside[aside-menu]')
		.cloneNode(true);
	const dashboardMenuContainer = window.document.querySelector(
		'div[dash-board-menu-container]',
	);

	dashboardMenuContainer.append(asideMenuTemplate);
})();

(() => {
	if (!localStorage.getItem('initialActive')) {
		localStorage.setItem('initialActive', '1')
	}

	const initialActive = localStorage.getItem('initialActive')

	let currentActiveButton = window.document.querySelectorAll(
		`button[for-dashboard-panel="${initialActive}"]`,
	);

	currentActiveButton.forEach((button) => {
		button.classList.add('--on');
	});

	let currentActivePanel = window.document.querySelector(
		`div[dashboard-panel-id="${initialActive}"]`,
	);

	currentActivePanel.classList.add('--on')

	window.document
		.querySelectorAll('button[aside-menu-container__option]')
		.forEach((button) => {
			button.addEventListener('click', () => {
				currentActivePanel.classList.remove('--on');

				const forDashboard = button.getAttribute('for-dashboard-panel');

				localStorage.setItem('initialActive', forDashboard)

				const newCurrentActivePanel = window.document.querySelector(
					`div[dashboard-panel-id="${forDashboard}"]`,
				);

				newCurrentActivePanel.classList.add('--on');

				currentActivePanel = newCurrentActivePanel;

				currentActiveButton.forEach((button) => {
					button.classList.remove('--on');
				});

				const newCurrentActiveButton = window.document.querySelectorAll(
					`button[for-dashboard-panel="${forDashboard}"]`,
				);

				newCurrentActiveButton.forEach((button) => {
					button.classList.add('--on');
				});

				currentActiveButton = newCurrentActiveButton;
			});
		});
})();

(() => {
	window.document
		.querySelectorAll('button[logout-button]')
		.forEach((button) => {
			button.addEventListener('click', async () => {
				await fetch ("/system/administracao/dashboard/logout/logout.php", {
					method: "POST"
				})

				location.reload();
			});
		});
})();
