
/* == Gestion MAILS et NOTIFICATIONS  ================================ */

let mailForm = document.getElementById('mailForm');
let mailFormBtn = mailForm.querySelector('button[type=submit]');

mailForm.addEventListener('submit', function (e) {
 	e.preventDefault()
 	const formData = new FormData(this);
 	const nxForm = new Formulaire (mailForm, formData);
	nxForm.verifForm();
})


/* == Changement MOT DE PASSE  ================================ */

let passForm = document.getElementById('passForm');
let passFormBtn = passForm.querySelector('button[type=submit]');

passForm.addEventListener('submit', function (e) {
 	e.preventDefault()
 	const formData = new FormData(this);
 	const nxForm = new Formulaire (passForm, formData);
	nxForm.verifForm();
})