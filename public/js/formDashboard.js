
/* == Update User STATUT  ================================ */
	const upUserForm = document.getElementById('upUserForm');
	upUserForm.addEventListener('submit', function (e) {
console.log('coucou');
 	e.preventDefault()
 	const formData = new FormData(this);
 	const nxForm = new Formulaire (this, formData);
	nxForm.verifForm();
	})

/* == Delete USER  ======================================= */
	const delUserForm = document.getElementById('delUserForm');
	delUserForm.addEventListener('submit', function (e) {
 	e.preventDefault()
 	const formData = new FormData(this);
 	const nxForm = new Formulaire (this, formData);
	nxForm.verifForm();
	})

/* == Ajout USER  ================================ */
	const addUserForm = document.getElementById('addUserForm');
	addUserForm.addEventListener('submit', function (e) {
 	e.preventDefault()
 	const formData = new FormData(this);
 	const nxForm = new Formulaire (this, formData);
	nxForm.verifForm();
	})