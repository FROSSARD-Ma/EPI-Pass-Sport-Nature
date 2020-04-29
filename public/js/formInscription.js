
// INSCRIPTION -------------------------------------------
let inscriptForm = document.getElementById('inscriptForm');

/* groupe */
let gpStatut = document.getElementById('groupeStatut');
const groupeElt = document.getElementById('groupe');
groupeElt.style.display = 'none';

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

/* buttons */
let prevBtn = document.getElementById('previous-btn');
prevBtn.style.display = 'none';
let nextBtn = document.getElementById('next-btn');
nextBtn.style.display = 'none';
let inscBtn = document.querySelector('button[type=submit]');
inscBtn.style.display = 'none';

/* == GESTIONS EVENEMENTS ================================ */
gpStatut.addEventListener('change', (event) => {	
	let statut = event.target.value;

	let nxInscription = new Inscription(inscriptForm, statut, groupeElt, gpName, gpMail, userElt, nameLabel, userName, userFirstname, userMail, userPass, inscBtn, nextBtn, prevBtn);
	nxInscription.refreshForm();
});