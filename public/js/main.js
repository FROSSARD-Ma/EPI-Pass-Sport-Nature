
let message = document.getElementById('message');

// INFO BULLE---------------------------------------------
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

// FORMULAIRE -----------------------------------------
const form = document.querySelector('form');
$('form').parsley();


// TABLEAU --------------------------------------------
$(document).ready(function() {
    $('#tableEquipt').DataTable();
} );