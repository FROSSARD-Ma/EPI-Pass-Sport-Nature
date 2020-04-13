

// INSCRIPTION -------------------------------------------
let inscForm = document.getElementById('form-inscription');
let gpStatut = document.getElementById('groupeStatut');
let inscBtn = inscForm.querySelector('button[type=submit]');
inscBtn.style.display = 'none';

/* groupe */
const groupeElt = document.getElementById('groupe');
groupeElt.style.display = 'none';
let gpH3= groupeElt.getElementsByTagName("h3");
let gpName = document.getElementById('groupeName');
let gpMail = document.getElementById('groupeMail');
/* user resp */
const userElt = document.getElementById('user');
userElt.style.display = 'none';
let nameLabel = document.getElementById('labelUserName');
let userName = document.getElementById('userName');
let userFirstname = document.getElementById('userFirstname');
let userMail = document.getElementById('userMail');
let userPass = document.getElementById('userPass');


/* == GESTIONS EVENEMENTS ================================ */
gpStatut.addEventListener('change', (event) => {	
	statut = event.target.value;
	let nxInscription = new Inscription(inscForm, statut, groupeElt, gpH3, gpName, gpMail, userElt, nameLabel, userName, userFirstname, userMail, userPass, inscBtn, nextBtn, prevBtn);
	nxInscription.refreshForm();
});
