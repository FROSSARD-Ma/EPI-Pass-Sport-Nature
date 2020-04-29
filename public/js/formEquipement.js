

// EQUIPEMENT -------------------------------------------
let inscForm = document.getElementById('form-addEquipt');

let activite  = document.getElementById('activiteId');
let nxActivite  = document.getElementById('activite-name');
nxActivite.style.display = 'none';

let categorie  = document.getElementById('categorieId');	
let nxCategorie  = document.getElementById('categorie-name');
nxCategorie.style.display = 'none';

let kit  = document.getElementById('kitId');	
let nxKit  = document.getElementById('kit');
nxKit.style.display = 'none';

let lot  = document.getElementById('lotId');
let nxLot 	 = document.getElementById('lot');
nxLot.style.display = 'none';

let addEquiptBtn = document.getElementById('addEquipt-btn');



/* == GESTIONS EVENEMENTS ================================ */
activite.addEventListener('change', (event) => {	

	if (event.target.value == 'nxActivite')
	{
		nxActivite.style.display = 'block';
	}
	else
	{
		nxActivite.style.display = 'none';
	}
	
});

categorie.addEventListener('change', (event) => {	

	if (event.target.value == 'nxCategorie')
	{
		nxCategorie.style.display = 'block';
	}
	else
	{
		nxCategorie.style.display = 'none';
	}
	
});

kit.addEventListener('change', (event) => {	
	if (event.target.value == 'nxKit')
	{
		nxKit.style.display = 'block';
	}
	else
	{
		nxKit.style.display = 'none';
	}
});

lot.addEventListener('change', (event) => {	

	if (event.target.value == 'nxLot')
	{
		nxLot.style.display = 'block';
	}
	else
	{
		nxLot.style.display = 'none';
	}
	
});

