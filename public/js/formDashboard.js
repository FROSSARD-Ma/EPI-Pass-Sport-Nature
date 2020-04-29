
/* == Update User STATUT  ================================ */
	let upUserForm = document.getElementById('upUserForm');
	let upUserBtn = upUserForm.querySelector('button[type=submit]');
	
	upUserForm.addEventListener('submit', function (e) {
	 	e.preventDefault()
	 	let formData = new FormData(this);
	 	let nxForm = new Formulaire (this, formData);
		nxForm.verifForm();
	})

/* == Delete USER  ======================================= */
	let delUserForm = document.getElementById('delUserForm');
	let delUserBtn = delUserForm.querySelector('button[type=submit]');

	delUserForm.addEventListener('submit', function (e) {
	 	e.preventDefault()
	 	let formData = new FormData(this);
	 	let nxForm = new Formulaire (this, formData);
		nxForm.verifForm();
	})

/* == Ajout USER  ================================ */
	let addUserForm = document.getElementById('addUserForm');
	let addUserBtn = addUserForm.querySelector('button[type=submit]');

	addUserForm.addEventListener('submit', function (e) {
	 	e.preventDefault()
	 	let formData = new FormData(this);
	 	let nxForm = new Formulaire (this, formData);
		nxForm.verifForm();
	})