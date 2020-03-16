<?php
namespace Epi_Model;

class Router {

	private $_page;
	private $_routes = [ 

		// ---- FRONT Controller -----------------------------------------------------
		/* Menu */
		"about" 		=> ['controller'=> '\Epi_Controller\FrontController', 'method'=>'about'],
		"home" 			=> ['controller'=> '\Epi_Controller\FrontController', 'method'=>'home'],
		"chapters" 		=> ['controller'=> '\Epi_Controller\FrontController', 'method'=>'chapters'],
		"contact" 		=> ['controller'=> '\Epi_Controller\FrontController', 'method'=>'contact'],
		"inscription" 	=> ['controller'=> '\Epi_Controller\FrontController', 'method'=>'inscription'],
		"admin" 		=> ['controller'=> '\Epi_Controller\FrontController', 'method'=>'admin'],
		"login" 		=> ['controller'=> '\Epi_Controller\FrontController', 'method'=>'login'],
		"logout" 		=> ['controller'=> '\Epi_Controller\FrontController', 'method'=>'logout'],

		/* Link Button */

		
		/* Erreur Page 404 */
		"page404" 		=> ['controller'=> '\Epi_Controller\FrontController', 'method'=>'page404'],

		// ---- USER Controller -----------------------------------------------------
		"creatUser" 	=> ['controller'=> '\Epi_Controller\UserController', 'method'=>'creatUser'],
		"users" 		=> ['controller'=> '\Epi_Controller\UserController', 'method'=>'users'],
		"loginUser" 	=> ['controller'=> '\Epi_Controller\UserController', 'method'=>'loginUser'],
		"nxPass" 		=> ['controller'=> '\Epi_Controller\UserController', 'method'=>'nxPass'],
		"creatPass" 	=> ['controller'=> '\Epi_Controller\UserController', 'method'=>'creatPass'],

		// ---- BOOK Controller -----------------------------------------------------
		/* Contact */
		"creatContact" 	=> ['controller'=> 'BookController', 'method'=>'creatContact'],

	];


	public function __construct($page)
	{
		$this->_page = $page;
	}

	public function getRoute()
	{
		$elements = explode('/', $this->_page); // crée un chemin sous format tableau
		return $elements[0] ; // page = premier élément de la route
	}

	public function getParams()
	{	
		$elements = explode('/', $this->_page); // tableau
		// suppression du premier element (page) dans le tableau
		unset($elements[0]); 
		// récupère les PARAMS
		for ($i=1; $i<count($elements); $i++)
		{
			$params[$elements[$i]] = $elements[$i+1];
			$i++;
		}
		// si pas de PARAMS, instancier PARAMS à null
		if (!isset($params)) $params = null;

		return $params;
	}	

	public function getController()
	{
		$route = $this->getRoute();
		$params = $this->getParams();

		if(!empty($route))
		{
			if (key_exists($route, $this->_routes))
			{
				$controller = $this->_routes[$route]['controller'];
				$method		= $this->_routes[$route]['method'];

				$currentController = new $controller();
				$currentController->$method($params);
			}
			else
			{
				$nxView = new \Alaska_Model\View ('page404');
	        	$nxView->getView();
			}
		}
		else
		{
			// Redirection page accueil
			$nxView = new \Alaska_Model\View();
        	$nxView->redirect('home');
		}
	}

}