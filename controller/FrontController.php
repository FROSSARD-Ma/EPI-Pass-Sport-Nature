<?php
namespace Epi_Controller;

class FrontController
{
    /* Menu ----------------------------------- */
     public function home($params) // $params = array : $params[1]
    {
		echo 'Page HOME';
    }



    /* Link Button ----------------------------*/
    



    /* Erreur 404  ----------------------------*/
    public function page404($params)
    {
        echo 'Page 404';
    }
}