<?php
namespace Epi_Model;

class Router {

    private $_url;
	private $_routes = [

    // ---- FRONT Controller -----------------------------------------------------
        /* Menu */
        "home"          => ['FrontController','home'],
        "404"           => ['FrontController','page404'],
        "inscription"   => ['FrontController','inscription'],
        "dashboard"     => ['FrontController','dashboard'],
        

    // ---- BACK Controller -----------------------------------------------------

    // ---- USER Controller -----------------------------------------------------
        "creatGroupe"   => ['UserController','creatGroupe'],
        "loginUser"     => ['UserController','loginUser'],

    ];

    public function __construct($url)
    {
        $this->_url = $url;
    }

    public function getRoute()
    {
        $page = explode('/', $this->_url); // crée un chemin sous format tableau
        return $page[0]; // route = premier élément de la route
    }

    public function getParams()
    {   
        $params = explode('/', $this->_url); // tableau
        unset($params[0]); // Suppression Element page
        if (!isset($params)) $params = null;
        return $params;
    }
    
	public function run()
    {
        $route = $this->getRoute();
        $params = $this->getParams();

        if(!empty($route))
        {
            if (key_exists($route, $this->_routes))
            {
                $controller = '\Epi_Controller\\'.$this->_routes[$route][0];
                $methode    = $this->_routes[$route][1];

                $currentController = new $controller();
                $currentController->$methode($params);
            }
            else
            {
                $nxView = new \Epi_Model\View('page404');
                $nxView->getView();
            }
        }
        else
        {
            $nxView = new \Epi_Model\View('home');
            $nxView->getView();
        }
    	
    }

}