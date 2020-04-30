
/* == Update User STATUT  ================================ */

const userForm  = document.getElementById('users');
form = userForm.querySelectorAll('form');

for (let i=0, nbForm=form.length; i<nbForm; i++) {
	
    form[i].addEventListener('submit', function (e) {
    	e.preventDefault();
    	let formData = new FormData(this);
	 		let nxForm = new Formulaire (this, formData);
	 	nxForm.verifForm();
    });
}