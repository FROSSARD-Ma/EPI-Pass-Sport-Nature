<?php
namespace Epi_Model;
use \Exception;

class AppException extends Exception
{

	private $_redirectionPage;

	public function __construct($message=NULL, $redirectionPage='')
    {  
      	parent::__construct($message);
      	$this->_redirectionPage = $redirectionPage;
      	$this->_message = $message;
    }

    public function getRedirection()
    {

      	if(empty($message))
      	{
			$_SESSION['erreur'] = 'ERREUR : ' . $this->_message;
      	}

      	if(empty($redirectionPage))
  		{
	      	$nxView = new \Epi_Model\View($this->_redirectionPage);
		}
		else
		{
			$nxView = new \Epi_Model\View('home');
		}
		$nxView->getView();
    }
}