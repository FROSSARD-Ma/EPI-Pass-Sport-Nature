
let message = document.getElementById('message');

// FORMULAIRE --------------------------------------------
const form = document.querySelector('form');
$('form').parsley();


// TABLEAU --------------------------------------------
$(document).ready(function() {
    $('#tableEquipt').DataTable();
} );