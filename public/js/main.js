const formulaire = document.querySelector('form');
$('form').parsley();


// FORM -------------------------------------------------------
let form = document.querySelector('#form_mail');
let button = form.querySelector('button[type=submit]');
let buttonText = button.textContent;


/* == GESTIONS EVENEMENTS ================================ */

form.addEventListener('submit', async function (e) {

  button.disabled = true;
  button.textContent = 'Chargement...';

  e.preventDefault()

  let data = new FormData(form);
  let response = await fetch(form.action,
  {
    method: 'POST',
    body: data
  })

console.log(response);
  
    if (response.ok === true)
    {
      let responseData = await response;
      console.log(responseData);
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