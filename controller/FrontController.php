<?php
namespace Epi_Controller;

class FrontController
{
    /* Menu ----------------------------------- */
    



    /* Link Button ----------------------------*/
    



    /* Erreur 404  ----------------------------*/
    public function page404($params)
    {
        $nxView = new \Epi_Model\View ('page404');
        $nxView->getView();
    }
}