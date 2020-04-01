<?php
namespace Epi_Controller;

class FrontController
{
    /* Menu ----------------------------------- */
    public function home($params)
    {
		$nxView = new \Epi_Model\View('home');
        $nxView->getView();
    }



    /* Link Button ----------------------------*/
    public function inscription($params)
    {
        $nxView = new \Epi_Model\View('inscription');
        $nxView->getView();
    }
    public function dashboard($params)
    {
        $nxView = new \Epi_Model\View('dashboard');
        $nxView->getView();
    }
    
    public function nxPass($params)
    {
        $nxView = new \Epi_Model\View('nxPass');
        $nxView->getView();
    }

    public function changePass($params)
    {
        $nxView = new \Epi_Model\View('changePass');
        $nxView->getView();
    }

    public function deconnexion($params)
    {
        unset($_SESSION['userId']); 
        unset($_SESSION['userFirstname']);
        unset($_SESSION['userStatut']);

        setcookie('userMail');
        setcookie('userPass');

        $_SESSION['message'] = 'Vous êtes déconnecté de votre espace !';

        $nxView = new \Epi_Model\View('home');
        $nxView->getView();
    }

    public function account($params)
    {
 
        $UserManager = new \Epi_Model\UserManager; 
        $dataUser = $UserManager->getUser($_SESSION['userId']);

        $user = new \Epi_Model\User($dataUser); // hydratation

        $nxView = new \Epi_Model\View('account');
        $nxView->getView(array (
            'user'=> $user));
    }


    /* Erreur 404  ----------------------------*/
    public function page404($params)
    {
        $nxView = new \Epi_Model\View('page404');
        $nxView->getView();
    }
}