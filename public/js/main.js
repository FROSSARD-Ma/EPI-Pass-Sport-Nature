const form = document.querySelector('form');
$('form').parsley();
let button = form.querySelector('button[type=submit]');
let buttonText = button.textContent;


// CHANGE MAIL -------------------------------------------------------
let mailForm = document.getElementById('mailForm');

let message = document.getElementById('message');

/* == GESTIONS EVENEMENTS ================================ */

mailForm.addEventListener('submit', function (e) {

  	button.disabled = true;
  	button.textContent = 'Chargement...';

 	e.preventDefault()

 	const formData = new FormData(this);

 	nxForm = new Formulaire (mailForm, formData);
	nxForm.verifForm();

	// Dans tous les cas on permet la soumission du formulaire à nouveau
	button.disabled = false;
	button.textContent = buttonText;

})