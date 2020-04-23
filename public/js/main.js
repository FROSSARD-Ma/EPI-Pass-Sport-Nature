
let message = document.getElementById('message');

// FORMULAIRE --------------------------------------------
const form = document.querySelector('form');
$('form').parsley();


window.Parsley.addValidator('maxFileSize', {
  validateString: function(_value, maxSize, parsleyInstance) {
    if (!window.FormData) {
      alert('You are making all developpers in the world cringe. Upgrade your browser!');
      return true;
    }
    var files = parsleyInstance.$element[0].files;
    return files.length != 1  || files[0].size <= maxSize * 1024;
  },
  requirementType: 'integer',
  messages: {
    fr: 'Ce fichier est plus grand que %s Kb.'
  }
});


// TABLEAU --------------------------------------------
$(document).ready(function() {
    $('#tableEquipt').DataTable();
} );
