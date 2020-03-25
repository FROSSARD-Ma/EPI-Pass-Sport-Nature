<?php
namespace Epi_Controller;

class UserController
{
	// ---- GROUPE  -----------------------------------------------------
	public function creatGroupe($params)
	{
    	/* Particulier */
		if ($_POST['groupeStatut'] == 'Particulier')
		{
			$groupeName		= $_POST['userName'];
			$groupeMail		= $_POST['userMail'];
		} 
		/* Groupe */
		else
		{
			$groupeName		= $_POST['groupeName'];
			$groupeMail		= $_POST['groupeMail'];
		}

		// Vérifier si Mail existe déjà
		$mailManager = new \Epi_Model\GroupeManager; 
	    $mailExist = $mailManager->existGroupe($groupeMail);
	    if ($mailExist) 
	    {
	    	// Message erreur
			echo 'le mail existe !!!!!';
	    }
	    else
	    {
	    	// Ajout utilisateur
				$groupeStatut 	= $_POST['groupeStatut'];

				$groupeManager = new \Epi_Model\GroupeManager; 
				$creatGroupe = $groupeManager->addGroupe($groupeName, $groupeMail, $groupeStatut);
				if ($creatGroupe) 
	    		{
					$this->creatUser($creatGroupe);
				}
				else
				{
					// Message erreur
					echo 'le groupe n\'a pas été créé';
				}
	    }

		// Nouvelle page 
		$nxView = new \Epi_Model\View();

	}

	// ---- USER  -----------------------------------------------------
	public function creatUser($params)
	{
 		$UserManager = new \Epi_Model\UserManager; 
		$creatUser = $UserManager->addUser($params);
		if ($creatUser)
		{
			// Envoyer Email de confirmation



			// Nouvelle page 
			$nxView = new \Epi_Model\View('dashboard');
			$nxView->getView();

		}
		else
		{
			// Message erreur
			echo 'le responsable n\a pas été créé';
		}


	}

	// ---- LOGIN ----------------------------------------------------
	public function loginUser($params)
	{
		
	}

	// ---- PASS -----------------------------------------------------
	public function nxPass($params)
	{

	}

	public function creatPass($params)
	{
		
	}
}
