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

    public function nxPass($params)
    {
        $nxView = new \Epi_Model\View('nxPass');
        $nxView->getView();
    }

    public function changePass($params)
    {

        echo $_POST['userMail'];exit;
        // Vérifier si le mail existe
            $mailManager = new \Epi_Model\UserManager; 
            $mailExist = $mailManager->existUser($_POST['userMail']);
            if ($mailExist)
            {
            // Récuperation idUser
            $nxUser = new \Epi_Model\User($mailExist);
            $userMail= $nxUser->getMail();

            $nxView = new \Epi_Model\View('changePass');
              $nxView->getView(array ('userId' => $userMail));
        }
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


    /* Erreur 404  ----------------------------*/
    public function page404($params)
    {
        $nxView = new \Epi_Model\View('page404');
        $nxView->getView();
    }
}