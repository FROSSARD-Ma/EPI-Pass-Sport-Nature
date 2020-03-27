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
	public function creatUser($groupeId)
	{
		
		$nxPassCrypt = $this->cryptPass($_POST['userPass']);

 		$UserManager = new \Epi_Model\UserManager; 
		$creatUser = $UserManager->addUser($groupeId, $nxPassCrypt);
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

	// ---- COOKIE -------------------------------------------
	public function addCookieUser()
	{
		$dureeCookie = time()+ 365*24*3600; // 1 an
		$secureHttpsCookie = true; // Https only

		setcookie('userMail', $_POST['userMail'], $dureeCookie, null, null, $secureHttpsCookie, false);
		setcookie('userPass', $_POST['userPass'], $dureeCookie, null, null, $secureHttpsCookie, false);
	}

	// ---- LOGIN -----------------------------------------------------
	public function loginUser($params)
	{
		// Vérifier si Utilisateur existe / mail
		$mailManager = new \Epi_Model\UserManager; 
	    $mailExist = $mailManager->existUser($_POST['userMail']);
	    if ($mailExist)
	    {
	    	$nxUser = new \Epi_Model\User($mailExist);

			if (password_verify($_POST['userPass'], $nxUser->getPass()))
			{
				// enregistrement pour la session
				$_SESSION['userId']			= $nxUser->getId();
				$_SESSION['userFirstname']	= $nxUser->getFirstname();
		        $_SESSION['userStatut']		= $nxUser->getStatut();

		        //-- Se SOUVENIR du MDP
		        if (isset($_POST['userRemember']))
		        { 
		            $this->addCookieUser();
		        }

		        $nxView = new \Epi_Model\View('dashboard');
		        $nxView->getView();
		    }
		    else
		    {
		       	// erreur

				$nxView = new \Epi_Model\View('home');
		        $nxView->getView();
		    }
	    }
	    else
	    {
	    	// Message erreur

	    	$nxView = new \Epi_Model\View('home');
		    $nxView->getView();
	    }
	}

	// ---- PASS -----------------------------------------------------
	public function cryptPass($password)
	{
        /*
        Hacher MDP en utiliant l'algorithme par défaut :
        BCRYPT, chaîne 60 caractères
        */
        return password_hash($password, PASSWORD_DEFAULT);
	}
	public function askPassMail()
	{
		// Vérifier si le mail existe
		$mailManager = new \Epi_Model\UserManager; 
	    $mailExist = $mailManager->existUser($_POST['userMail']);
	    if ($mailExist)
	    {
	    	// Envoyer un email


	    	// Faire message Pop-Up de confirmation
			// JS
			$_SESSION['message'] = 'Une demande de changement vous a été envoyé par Email !';
			// Redirection page
	    	$nxView = new \Epi_Model\View('home');
		    $nxView->getView();
	    }
	    else
	    {
	    	// Erreur : vous n'êtes pas enregistré avec cet email
echo 'vous n\'êtes pas enregistré avec cet email';

	    	$nxView = new \Epi_Model\View('nxPass');
		    $nxView->getView();
	    }
	}

	public function addPass()
	{
		if(isset($_POST['userPass1']) AND !empty($_POST['userPass1'])
			AND isset($_POST['userPass2'])
			AND !empty($_POST['userPass2']))
		{
			if ($_POST['userPass1'] == $_POST['userPass2'])
			{
				$nxPassCrypt = $this->cryptPass($_POST['userPass1']);

				$passManager = new \Epi_Model\UserManager; 
			    if ($passManager->updatePass($_SESSION['userId'], $nxPassCrypt))
			    {
			    	
			    	// Faire message Pop-Up de confirmation
			    	// JS
					$_SESSION['message'] = 'Votre mot de passe a été mis à jour !';
			    	// Redirection page
			    	$nxView = new \Epi_Model\View('home');
				    $nxView->getView();
			    }
			    else
			    {
			    	// Erreur : vous n'êtes pas enregistré avec cet email
echo 'vous n\'êtes pas enregistré avec cet email';
			    	$nxView = new \Epi_Model\View('nxPass');
				    $nxView->getView();
			    }

			}
			else
			{
echo 'Les deux mot de passe ne correspondent pas';
				$nxView = new \Epi_Model\View('changePass');
				$nxView->getView();
			}
		}
		else
		{
echo 'Il y a un problème';	
			$nxView = new \Epi_Model\View('changePass');
			$nxView->getView();		
		}



	}




}
