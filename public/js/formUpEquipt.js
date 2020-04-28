
/* == Modification EQUIPEMENT  ================================ */

let upEquiptForm = document.getElementById('upEquiptForm');
let upEquiptFormBtn = upEquiptForm.querySelector('button[type=submit]');

upEquiptForm.addEventListener('submit', function (e) {
 	console.log('coucou');
 	e.preventDefault()
 	const formData = new FormData(this);
 	const nxForm = new Formulaire (upEquiptForm, formData);
	nxForm.verifForm();
})