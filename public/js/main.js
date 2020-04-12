


let mailForm = document.getElementById('mailForm');

let message = document.getElementById('message');


// FORMULAIRE --------------------------------------------
const form = document.querySelector('form');
let nextBtn = document.getElementById('next-btn');
let prevBtn = document.getElementById('previous-btn');
let button = form.querySelector('button[type=submit]');

$('form').parsley();

// INSCRIPTION -------------------------------------------
let inscForm = document.getElementById('form-inscription');
let gpStatut = document.getElementById('groupeStatut');
let statut = gpStatut.value;
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
	gpStatut = event.target.value;
	let nxInscription = new Inscription(inscForm, gpStatut, groupeElt, gpH3, gpName, gpMail, userElt, nameLabel, userName, userFirstname, userMail, userPass, inscBtn, nextBtn, prevBtn);
	nxInscription.refreshForm();
});




// mailForm.addEventListener('submit', function (e) {
//		let buttonText = button.textContent;
//   	button.disabled = true;
//   	button.textContent = 'Chargement...';

//  	e.preventDefault()

//  	const formData = new FormData(this);

//  	nxForm = new Formulaire (mailForm, formData);
// 	nxForm.verifForm();

// 	button.disabled = false;
// 	button.textContent = buttonText;

// })

