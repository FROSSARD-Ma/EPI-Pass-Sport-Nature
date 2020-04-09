
// INSCRIPTION -------------------------------------------------------

let inscForm = document.getElementById('inscForm');
let gpStatut = document.getElementById('groupeStatut');

/* == GESTIONS EVENEMENTS ================================ */

gpStatut.addEventListener('change', () =>
{	
	let statut = gpStatut.value;
	let groupeElt = inscForm.elements.groupe;
	let userElt = inscForm.elements.user;
	let nameLabel = inscForm.elements.labelUserName;
	let btnInsc = inscForm.elements.button;

	nxInscription = new Inscription (inscForm, statut, groupeElt, userElt, nameLabel, btnInsc);
	nxInscription.editForm();
});