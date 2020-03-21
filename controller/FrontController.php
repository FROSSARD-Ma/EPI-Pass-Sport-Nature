<?php
namespace Epi_Controller;

class FrontController
{
    /* Menu ----------------------------------- */
     public function home($params) // $params = array : $params[1]
    {
		$nxView = new \Epi_Model\View('home');
        $nxView->getView();
    }



    /* Link Button ----------------------------*/
    



    /* Erreur 404  ----------------------------*/
    public function page404($params)
    {
        $nxView = new \Epi_Model\View('page404');
        $nxView->getView();
    }
}