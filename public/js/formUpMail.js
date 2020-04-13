
/* == GESTIONS EVENEMENTS ================================ */

let mailForm = document.getElementById('mailForm');

mailForm.addEventListener('submit', function (e) {
		let buttonText = button.textContent;
  	button.disabled = true;
  	button.textContent = 'Chargement...';

 	e.preventDefault()

 	const formData = new FormData(this);

 	nxForm = new Formulaire (mailForm, formData);
	nxForm.verifForm();

	button.disabled = false;
	button.textContent = buttonText;

})
