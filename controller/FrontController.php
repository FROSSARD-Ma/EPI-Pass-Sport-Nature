<?php
namespace Epi_Controller;

class FrontController
{
    /* TOP Menu ----------------------------------- */
    public function home($params)
    {
		$csrf = new \Epi_Model\SecuriteCsrf('login');
        $token = $csrf->getToken();

        $nxView = new \Epi_Model\View('home');
        $nxView->getView();
    }
    public function contact($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('contact');
        $token = $csrf->getToken();

        $nxView = new \Epi_Model\View('contact');
        $nxView->getView();
    }

    public function dashboard($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('dashboard');
        $token = $csrf->getToken();

        /* Liste USERS */
        $UserManager = new \Epi_Model\UserManager;
        $dataUsers = $UserManager->getUsers($_SESSION['groupeId']);
        foreach ($dataUsers as $data)
        {
            $user = new \Epi_Model\User($data);
            $users[] = $user; // Tableau d'objet
        }

        $nxView = new \Epi_Model\View('dashboard');
        $nxView->getView(array (
            'userResp'=> $userResp,
            'users'=> $users
        ));
    }

    public function equipement($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('equipement');
        $token = $csrf->getToken();

        $nxView = new \Epi_Model\View('equipement');
        $nxView->getView();
    }

    public function account($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('account');
        $token = $csrf->getToken();

        $UserManager = new \Epi_Model\UserManager; 
        $dataUser = $UserManager->getUser($_SESSION['userId']);

        $user = new \Epi_Model\User($dataUser); // hydratation

        $nxView = new \Epi_Model\View('account');
        $nxView->getView(array (
            'user'=> $user));
    }

    public function deconnexion($params)
    {
        unset($_SESSION['userId']); 
        unset($_SESSION['userFirstname']);
        unset($_SESSION['userStatut']);

        setcookie('userMail');
        setcookie('userPass');

        $_SESSION['message'] = 'Vous êtes déconnecté de votre espace !';

        $nxView = new \Epi_Model\View();
        $nxView->redirectView('home');
    }


    /* Link Button ----------------------------*/
    public function inscription($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('inscription');
        $token = $csrf->getToken();

        $nxView = new \Epi_Model\View('inscription');
        $nxView->getView();
    }

    public function nxPass($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('nxPass');
        $token = $csrf->getToken();
        
        $nxView = new \Epi_Model\View('nxPass');
        $nxView->getView();
    }

    public function changePass($params)
    {

        $csrf = new \Epi_Model\SecuriteCsrf('changePass');
        $token = $csrf->getToken();
        
        $nxView = new \Epi_Model\View('changePass');
        $nxView->getView();
    }


    /* Erreur 404  ----------------------------*/
    public function page404($params)
    {
        $nxView = new \Epi_Model\View('page404');
        $nxView->getView();
    }
}