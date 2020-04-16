

// EQUIPEMENT -------------------------------------------
let inscForm = document.getElementById('form-addEquipt');

let activite  = document.getElementById('activiteId');
let nxActivite  = document.getElementById('activite-name');
nxActivite.style.display = 'none';

let categorie  = document.getElementById('categorieId');	
let nxCategorie  = document.getElementById('categorie-name');
nxCategorie.style.display = 'none';

let produit  = document.getElementById('produit');
produit.style.display = 'block';

let controle = document.getElementById('controle');
controle.style.display = 'block';

let kit  = document.getElementById('kit');
nxKit.style.display = 'none';

let lot 	 = document.getElementById('lot');
nxLot.style.display = 'none';

let addEquiptBtn = document.getElementById('addEquipt-btn');
addEquiptBtn.style.display = 'none';

let previousBtn = document.getElementById('previous-btn');
previousBtn.style.display = 'none';

let nextBtn = document.getElementById('next-btn');
nextBtn.style.display = 'block';



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

