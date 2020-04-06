<?php
namespace Epi_Controller;

class FrontController
{
    /* TOP Menu ----------------------------------- */
    public function home($params)
    {
		$nxView = new \Epi_Model\View('home');
        $nxView->getView();
    }
    public function contact($params)
    {
        $nxView = new \Epi_Model\View('contact');
        $nxView->getView();
    }

    public function dashboard($params)
    {
        $nxView = new \Epi_Model\View('dashboard');
        $nxView->getView();
    }

    public function account($params)
    {
        $nxView = new \Epi_Model\View('account');
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


    /* Link Button ----------------------------*/
    public function inscription($params)
    {
        $nxView = new \Epi_Model\View('inscription');
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




    /* Erreur 404  ----------------------------*/
    public function page404($params)
    {
        $nxView = new \Epi_Model\View('page404');
        $nxView->getView();
    }
}