<?php
namespace Epi_Controller;

class UserController
{
	// ---- GROUPE  -----------------------------------------------------
	public function creatGroupe($params)
	{
		try
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
				throw new \Epi_Model\AppException('Un compte existe déjà avec cet mail.', 'home');
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
						throw new \Epi_Model\AppException('il y a eu un problème, le groupe n\'a pas été créé', 'inscription');
					}
		    }
		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	// ---- USER  -----------------------------------------------------
	public function creatUser($groupeId)
	{
		try
		{
			$nxPassCrypt = $this->cryptPass($_POST['userPass']);

	 		$UserManager = new \Epi_Model\UserManager; 
			$creatUser = $UserManager->addUser($groupeId, $nxPassCrypt);
			if ($creatUser)
			{
				// Envoyer Email de confirmation


				// Message
				$_SESSION['message'] = 'Votre inscription est validée ! Vous allez recevoir un email de confirmation.';
				// Nouvelle page 
				$nxView = new \Epi_Model\View('dashboard');
				$nxView->getView();
			}
			else
			{
				// Message erreur
				throw new \Epi_Model\AppException('votre compte n\a pas été créé.', 'inscription');
			}

		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
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
		try
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
					throw new \Epi_Model\AppException('Votre mot de passe n\'est pas valide !', 'home');
			    }
		    }
		    else
		    {
				throw new \Epi_Model\AppException('Aucun compte n\'est enregistré avec cet email !','home');
		    }
		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
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
		try
		{
			// Vérifier si le mail existe
			$mailManager = new \Epi_Model\UserManager; 
		    $mailExist = $mailManager->existUser($_POST['userMail']);
		    if ($mailExist)
		    {
		    	// Récuperation idUser
				$nxUser = new \Epi_Model\User($mailExist);
				$userId = $nxUser->getId();
				$userMail= $nxUser->getMail();

		    	// Envoyer un email
		    	$object = 'Changement de mot de passe';
		    	$to = $_POST['userMail'];
		    	$message = "
	                <h2>Demande de modification de mot de passe</h2>
	                <div>
		                <p>Bonjour,</p>
		                <p>Vous souhaitez modifier votre mot de passe :</p>
		               	<br>
		                <form method='post' action='https://epi.pass-sport-nature.fr/changePass'>
							<input type='hidden' id='userMail' name='userMail' value='$userMail'>
							<button type='submit'>Changer de Mot de passe</button>
		                </form>
		                <br>
		            </div>
		    	";

		    	$nxEmail = new \Epi_Model\Email($object, $to, $message);
			    $nxEmail->sendEmail();

		    	// Message
				$_SESSION['message'] = 'Une demande de changement vous a été envoyé par Email !';
				// Redirection page
		    	$nxView = new \Epi_Model\View('home');
			    $nxView->getView();
		    }
		    else
		    {
		    	// Message erreur
				throw new \Epi_Model\AppException('aucun compte n\'est enregistré avec cet Email !', 'nxPass');
		    }
		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	public function addPass()
	{
		try
		{
			if(isset($_POST['userId']) AND !empty($_POST['userId']))
			{
				$userId = $_POST['userId'];
			}
			else
			{
				$userId = $_SESSION['userId'];
			}

			if ($userId)
			{
				echo 'coucou'; 
			// 	if(isset($_POST['userPass1']) AND !empty($_POST['userPass1']) AND isset($_POST['userPass2'])AND !empty($_POST['userPass2']))
			// 	{
			// 		if ($_POST['userPass1'] == $_POST['userPass2'])
			// 		{
			// 			$nxPassCrypt = $this->cryptPass($_POST['userPass1']);
			// 			$passManager = new \Epi_Model\UserManager; 
						
			// 			if ($passManager->updatePass($userId), $nxPassCrypt)
			// 		    {
			// 		    	// Message		    	
			// 				$_SESSION['message'] = 'Votre mot de passe a été mis à jour !';
			// 		    	// Redirection page
			// 		    	$nxView = new \Epi_Model\View('home');
			// 			    $nxView->getView();
			// 		    }
			// 		    else
			// 		    {
			// 		    	// Message erreur
			// 				throw new \Epi_Model\AppException('aucun compte n\'est enregistré avec cet Email !', 'nxPass');
			// 		    }
			// 		}
			// 		else
			// 		{
			// 			// Message erreur
			// 			throw new \Epi_Model\AppException('les deux mots de passe ne correspondent pas !', 'changePass');
			// 		}
			// 	}
			// 	else
			// 	{
			// 		// Message erreur
			// 		throw new \Epi_Model\AppException('les deux mots de passes n\'ont pas été renseignés', 'changePass');	
			// 	}
			}
			else 
			{
				// Message erreur
				throw new \Epi_Model\AppException('Aucun compte na été identifié', 'home');	
			}
		}	
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	// ---- CONTACT -----------------------------------------------------
	public function sendEmailContact()
	{
		
	}

}
