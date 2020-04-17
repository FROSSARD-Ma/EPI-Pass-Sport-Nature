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
        "nxPass"        => ['FrontController','nxPass'],
        "changePass"    => ['FrontController','changePass'],
        "deconnexion"   => ['FrontController','deconnexion'],
        "account"       => ['FrontController','account'],
        "contact"       => ['FrontController','contact'],
        "equipement"    => ['FrontController','equipement'],
        "nxEquipt"      => ['FrontController','nxEquipt'],
        
    // ---- BACK Controller -----------------------------------------------------
        "creatEquipt"    => ['BackController','creatEquipt'],
        "delEquipt"      => ['BackController','delEquipt'],
        "Equipt"         => ['BackController','Equipt'],




    // ---- USER Controller -----------------------------------------------------
        "creatGroupe"       => ['UserController'    ,'creatGroupe'],
        "loginUser"         => ['UserController'    ,'loginUser'],
        "upMail"            => ['UserController'    ,'upMail'],
        "upPass"            => ['UserController'    ,'upPass'],
        "askPassMail"       => ['UserController'    ,'askPassMail'],
        "addPass"           => ['UserController'    ,'addPass'],
        "sendEmailContact"  => ['UserController'    ,'sendEmailContact'],
        "addUser"           => ['UserController'    ,'addUser'],
        "delUser"           => ['UserController'    ,'delUser'],
        "upUser"            => ['UserController'    ,'upUser']
    ];

    public function __construct($url)
    {
        $this->_url = $url;
    }

    public function getRoute()
    {
        $elements = explode('/', $this->_url); // crée un chemin sous format tableau
        return $elements[0]; // route = premier élément de la route
    }

    public function getParams()
    {   
        $elements = explode('/', $this->_url); // tableau
        unset($elements[0]); // Suppression Element page

// récupère les PARAMS
for ($i=1; $i<count($elements); $i++)
{
    $params[$elements[$i]] = $elements[$i+1];
    $i++;
}

        if (!isset($params)) $params = null;
        return $params;
    }

    public function getCookie()
    {
        // Vérifie s'il existe un COOKIE
        if (isset($_COOKIE['userMail']) && isset($_COOKIE['userPass'])) 
        {   
            // Vérifier si Utilisateur existe / mail
            $mailManager = new \Epi_Model\UserManager; 
            $mailExist = $mailManager->existUser($_COOKIE['userMail']);
            if ($mailExist)
            {
                $nxUser = new \Epi_Model\User($mailExist);

                if (password_verify($_COOKIE['userPass'], $nxUser->getPass()))
                {
                    // enregistrement pour la session
                    $_SESSION['userId']         = $nxUser->getId();
                    $_SESSION['userFirstname']  = $nxUser->getFirstname();
                    $_SESSION['userStatut']     = $nxUser->getStatut();
                }
            }
        }
    }
    
	public function run()
    {
        $this->getCookie();
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
            if ($_SESSION['userId'])
            {
                $nxView = new \Epi_Model\View('dashboard');
            }
            else
            {
                $nxView = new \Epi_Model\View('home');
            }
           
            $nxView->getView();
        }
    	
    }

}