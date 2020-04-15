
let message = document.getElementById('message');

// FORMULAIRE --------------------------------------------
const form = document.querySelector('form');
let nextBtn = document.getElementById('next-btn');
let prevBtn = document.getElementById('previous-btn');
let button = document.querySelector('button[type=submit]');

$('form').parsley();


// var submitBtn = document.querySelectorAll('button[type=submit]');
// for (var i = 0; i < submitBtn.length; i++) {
//   submitBtn[i].onclick = validSubmit;
// }
// function validSubmit(e) {
// console.log('coucou');
//   e.preventDefault()
//  	const formData = new FormData(submitBtn[i]);
//  	const nxForm = new Formulaire (submitBtn[i], formData);
// 	nxForm.verifForm();
// }
