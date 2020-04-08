const form = document.querySelector('form');
$('form').parsley();
let button = form.querySelector('button[type=submit]');
let buttonText = button.textContent;



// CHANGE MAIL -------------------------------------------------------
let mailForm = document.getElementById('mailForm')


/* == GESTIONS EVENEMENTS ================================ */

mailForm.addEventListener('submit', async function (e) {

  	button.disabled = true;
  	button.textContent = 'Chargement...';

 	e.preventDefault()

 	const formData = new FormData(this);
 	try {
 		let response = await fetch(form.action,
		{
	      	method: 'post',
	      	body: formData
	    })

		if (response.ok === true)
	    {
	      let responseData = await response;
	      // Message ok
	      
	    
	    } 
	    else
	    {
	      	// Message erreur : réponse n'est pas bonne (pas 200), on affiche les erreurs
			throw new ('une erreur est survenue.');
	    }
 	}
 	catch (e) {
 		alert(e);
 	}
	

	// Dans tous les cas on permet la soumission du formulaire à nouveau
	button.disabled = false;
	button.textContent = buttonText;

})