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



    /* Erreur 404  ----------------------------*/
    public function page404($params)
    {
        $nxView = new \Epi_Model\View('page404');
        $nxView->getView();
    }
}