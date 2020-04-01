
// INSCRIPTION -------------------------------------------------------

let formInsc = document.getElementById('form-inscription');
let gpStatut = document.getElementById('groupeStatut');

/* == GESTIONS EVENEMENTS ================================ */

gpStatut.addEventListener('change', () =>
{	
	let statut = gpStatut.value;
	let groupeElt = formInsc.elements.groupe;
	let userElt = formInsc.elements.user;
	let nameLabel = formInsc.elements.labelUserName;
	let btnInsc = formInsc.elements.button;

	nxInscription = new Inscription (formInsc, statut, groupeElt, userElt, nameLabel, btnInsc);
	nxInscription.editForm();
});