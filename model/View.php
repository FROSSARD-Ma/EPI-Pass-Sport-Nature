<?php 
namespace Epi_Model;

class View
{
	private $_page;
	
	public function __construct($page = null)
	{
		$this->_page = $page;
	}

	public function getView($datas = array()) /* Crée tableau pour pouvoir récupérer plusieurs variable GET */
	{
		// crée dynamiquement la variable après avoir parcouru $datas
		extract($datas);  // resultat : $entite

		//== TEMPLATING - TWIG =========================
		$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views/templates');
		$twig = new \Twig\Environment($loader, [
		    'cache' => false, // __DIR__ .'/compilation_cache',
		]);
		// Ajout variable de SESSION
		$twig->addGlobal('session', $_SESSION);

		

		echo $twig->render($this->_page . '.twig');
		
	}

	public function redirect($route)
	{
		header('Location:'.HOST.'index.php?url='.$route);
		exit;
	}

}
?>
