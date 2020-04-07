const form = document.querySelector('form');
$('form').parsley();
let button = form.querySelector('button[type=submit]');
let buttonText = button.textContent;



// CHANGE MAIL -------------------------------------------------------
let mailForm = document.getElementById('form_mail');


/* == GESTIONS EVENEMENTS ================================ */

mailForm.addEventListener('submit', async function (e) {

  	button.disabled = true;
  	button.textContent = 'Chargement...';

 	e.preventDefault()

	let data = new FormData(mailForm);
console.log(data);

  	let response = await fetch(mailForm.action,
  	{
    	method: 'POST',
    	body: data
  	})

	if (response.ok === true)
    {
      let responseData = await response;

      // Message ok
      alert('Mail a été changé OK');
    
    } 
    else
    {
      // La réponse n'est pas bonne (pas 200), on affiche les erreurs
    alert('Une erreur est survenue');
    }

  // Dans tous les cas on permet la soumission du formulaire à nouveau
  button.disabled = false;
  button.textContent = buttonText;

})