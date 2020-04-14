<?php
namespace Epi_Controller;

class UserController
{
	// ---- GROUPE  -----------------------------------------------------
	public function creatGroupe($params)
	{
		try
		{	
			//Ajout d'un TOKEN faille CSRF 
			$csrf = new \Epi_Model\SecuriteCsrf('inscription');
			$inscriptionToken = $csrf->verifToken(HOST.'inscription');
			if ($inscriptionToken)
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
			else
			{
				throw new \Epi_Model\AppException('vous avez dépassé le temps d\'envoie du formulaire. Rechargez la page et validez !', 'inscription');
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
				$nxView = new \Epi_Model\View('home');
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

	public function addUser()
	{
		try
		{
	 		$UserManager = new \Epi_Model\UserManager;
	 		$userPass = $UserManager->creatPass();
			$nxPassCrypt = $this->cryptPass($userPass);
			$addUser = $UserManager->addUser($_SESSION['groupeId'], $nxPassCrypt);
			if ($addUser)
			{
				// Message
				$_SESSION['message'] = 'L\'inscription est validée !';
				// Nouvelle page 
				$nxView = new \Epi_Model\View();
				$nxView->redirectView('dashboard');
			}
			else
			{
				// Message erreur
				throw new \Epi_Model\AppException('l\'utilisateur n\'a pas été créé.', 'dashboard');
			}

		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	public function upUser()
	{
		try
		{
			$csrf = new \Epi_Model\SecuriteCsrf('dashboard');
			$dashboardToken = $csrf->verifToken(HOST.'dashboard');
			if ($dashboardToken)
			{
		 		$UserManager = new \Epi_Model\UserManager;
		 		$upUser = $UserManager->updateUser($_POST['userId'], $_POST['userStatut']);
		 		if ($upUser)
			    {
			    	$_SESSION['message'] = 'le statut utilisateur a été mis à jour !';
					$nxView = new \Epi_Model\View();
					$nxView->redirectView('dashboard');
			    }
			    else
			    {
			    	// Message erreur
					throw new \Epi_Model\AppException('le statut utilisateur n\'a pas été mis à jour.', 'dashboard');
			    }
		 	}
			else
			{
				throw new \Epi_Model\AppException('vous avez dépassé le temps d\'envoie du formulaire. Rechargez la page et validez !', 'dashboard');
			}

		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	public function delUser()
	{
		try
		{
			$csrf = new \Epi_Model\SecuriteCsrf('dashboard');
			$dashboardToken = $csrf->verifToken(HOST.'dashboard');
			if ($dashboardToken)
			{
		 		$UserManager = new \Epi_Model\UserManager;
		 		$delUser = $UserManager->deleteUser($_POST['userId']);
		 		if ($delUser)
			    {
			    	$_SESSION['message'] = 'L\'utilisateur a été supprimé !';
					$nxView = new \Epi_Model\View();
					$nxView->redirectView('dashboard');
			    }
			    else
			    {
			    	// Message erreur
					throw new \Epi_Model\AppException('l\'utilisateur n\'a pas été supprimé.', 'dashboard');
			    }
		 	}
			else
			{
				throw new \Epi_Model\AppException('vous avez dépassé le temps d\'envoie du formulaire. Rechargez la page et validez !', 'dashboard');
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
			//Ajout d'un TOKEN faille CSRF 
			$csrf = new \Epi_Model\SecuriteCsrf('login');
			$inscriptionToken = $csrf->verifToken(HOST.'home');
			if ($inscriptionToken)
			{	
				// Vérifier si Utilisateur existe / mail
				$mailManager = new \Epi_Model\UserManager; 
			    $mailExist = $mailManager->existUser($_POST['userMail']);
			    if ($mailExist)
			    {
			    	$nxUser = new \Epi_Model\User($mailExist);
					if (password_verify($_POST['userPass'], $nxUser->getPass()))
					{
						$groupeId = $nxUser->getGroupeId();

						/* User */
						$_SESSION['userId']			= $nxUser->getId();
						$_SESSION['userName']		= $nxUser->getName();
						$_SESSION['userFirstname']	= $nxUser->getFirstname();
				        $_SESSION['userStatut']		= $nxUser->getStatut();
						
						/* Groupe */
						$groupeManager = new \Epi_Model\GroupeManager;
						$groupe = $groupeManager->getGroupe($groupeId);
					    if ($groupe)
					    {
					    	$nxGroupe = new \Epi_Model\Groupe($groupe);
							$_SESSION['groupeId']		= $nxGroupe->getId();
							$_SESSION['groupeStatut']	= $nxGroupe->getStatut();
							$_SESSION['groupeName']		= $nxGroupe->getName();

						}
				        //-- Se SOUVENIR du MDP
				        if (isset($_POST['userRemember']))
				        { 
				            $this->addCookieUser();
				        }
				        $nxView = new \Epi_Model\View();
				        $nxView->redirectView('dashboard');
				    }
				    else
				    {
						throw new \Epi_Model\AppException('il ne s\'agit pas du bon mot de passe !', 'home');
				    }
			    }
			    else
			    {
					throw new \Epi_Model\AppException('Aucun compte n\'est enregistré avec cet email !','home');
			    }    
			}
			else
			{
				throw new \Epi_Model\AppException('vous avez dépassé le temps d\'envoie du formulaire d\'identification. Rechargez la page et validez votre connexion !', 'home');
			}
		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	// ---- MAIL -----------------------------------------------------
	public function upMail($params)
	{
		try
		{
			//Ajout d'un TOKEN faille CSRF 
			$csrf = new \Epi_Model\SecuriteCsrf('account');
			$upMailToken = $csrf->verifToken(HOST.'account');
			if ($upMailToken)
			{
				// Changement EMAIL
				if(isset($_POST['userMail']) AND !empty($_POST['userMail']))
				{
					$passManager = new \Epi_Model\UserManager; 
				    if ($passManager->updateMail($_SESSION['userId']))
				    {
				    	// Message		    	
						$_SESSION['message'] = 'Votre adresse Email a été mis à jour !';
				    	// Redirection page
				    	$nxView = new \Epi_Model\View();
					    $nxView->redirectView('account');
					}
					else
					{
						// Message erreur
						throw new \Epi_Model\AppException('une erreur est survenue lors de l\'enregistrement', 'account');
					}
				}
				else
				{
					// Message erreur
					throw new \Epi_Model\AppException('une adresse Email valide est obligatoire', 'account');
				}
			}
			else
			{
				throw new \Epi_Model\AppException('vous avez dépassé le temps d\'envoie du formulaire. Rechargez la page et validez !', 'account');
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
			//Ajout d'un TOKEN faille CSRF 
			$csrf = new \Epi_Model\SecuriteCsrf('nxPass');
			$nxPassToken = $csrf->verifToken(HOST.'nxPass');
			if ($nxPassToken)
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
			                <p>Vous souhaitez modifier votre mot de passe !</p>

			                Rendez-vous à cette adresse : <a href='https://epi.pass-sport-nature.fr/changePass'>Changer mon mot de passe</a> </p>
			               	<br>
			            </div>
			    	";

			    	$nxEmail = new \Epi_Model\Email($object, $to, $message);
				    $nxEmail->sendEmail();

			    	// Message
					$_SESSION['message'] = 'Une demande de changement vous a été envoyé par Email !';
					// Redirection page
			    	$nxView = new \Epi_Model\View();
				    $nxView->redirectView('home');
			    }
			    else
			    {
			    	// Message erreur
					throw new \Epi_Model\AppException('aucun compte n\'est enregistré avec cet Email !', 'nxPass');
			    }
			}
			else
			{
				throw new \Epi_Model\AppException('vous avez dépassé le temps d\'envoie du formulaire. Rechargez la page et validez !', 'nxPass');
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
			//Ajout d'un TOKEN faille CSRF 
			$csrf = new \Epi_Model\SecuriteCsrf('changePass');
			$upPassToken = $csrf->verifToken(HOST.'changePass');
			if ($upPassToken)
			{
				if(isset($_POST['userMail']) AND !empty($_POST['userMail']))
				{
					// Vérifier si le mail existe
					$mailManager = new \Epi_Model\UserManager; 
				    $mailExist = $mailManager->existUser($_POST['userMail']);
				    if ($mailExist)
				    {
				    	// Récuperation idUser
						$nxUser = new \Epi_Model\User($mailExist);
						$userId = $nxUser->getId();

						if(isset($_POST['userPass1']) AND !empty($_POST['userPass1']) AND isset($_POST['userPass2'])AND !empty($_POST['userPass2']))
						{
							if ($_POST['userPass1'] == $_POST['userPass2'])
							{
								// Vérification conformité mot de passe
								if (preg_match('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{6,20})#', $_POST['userPass1']))
								{
									$nxPassCrypt = $this->cryptPass($_POST['userPass1']);
									$passManager = new \Epi_Model\UserManager; 
									
									if ($passManager->updatePass($userId, $nxPassCrypt))
								    {
								    	// Message		    	
										$_SESSION['message'] = 'Votre mot de passe a été mis à jour !';
								    	// Redirection page
								    	$nxView = new \Epi_Model\View();
									    $nxView->redirectView('home');
								    }
								    else
								    {
								    	// Message erreur
										throw new \Epi_Model\AppException('aucun compte n\'est enregistré avec cet Email !', 'nxPass');
								    }
								}
							    else
							    {
							        // Message erreur
									throw new \Epi_Model\AppException('votre mot de passe n\'est pas conforme.', 'changePass');
								}    
							}
							else
							{
								// Message erreur
								throw new \Epi_Model\AppException('les deux mots de passe ne correspondent pas !', 'changePass');
							}
						}
						else
						{
							// Message erreur
							throw new \Epi_Model\AppException('les deux mots de passes n\'ont pas été renseignés.', 'changePass');	
						}
					}
					else
					{
						// Message erreur
						throw new \Epi_Model\AppException('aucun compte n\'est enregistré avec cet Email !', 'changePass');
					}
				}
				else
				{
					// Message erreur
					throw new \Epi_Model\AppException('une adresse email valide est nécessaire.', 'changePass');
				}
			}
			else
			{
				throw new \Epi_Model\AppException('vous avez dépassé le temps d\'envoie du formulaire. Rechargez la page et validez !', 'changePass');
			}

		}	
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	public function upPass()
	{
		try
		{	
			//Ajout d'un TOKEN faille CSRF 
			$csrf = new \Epi_Model\SecuriteCsrf('account');
			$upPassToken = $csrf->verifToken(HOST.'account');
			if ($upPassToken)
			{
				$userId = $_SESSION['userId'];
				
				if(isset($_POST['userPass1']) AND !empty($_POST['userPass1']) AND isset($_POST['userPass2'])AND !empty($_POST['userPass2']))
				{
					if ($_POST['userPass1'] == $_POST['userPass2'])
					{
						// Vérification conformité mot de passe
						if (preg_match('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{6,20})#', $_POST['userPass1']))
						{
					        $nxPassCrypt = $this->cryptPass($_POST['userPass1']);
							$passManager = new \Epi_Model\UserManager; 
							
							if ($passManager->updatePass($userId, $nxPassCrypt))
						    {
						    	// Message		    	
								$_SESSION['message'] = 'Votre mot de passe a été mis à jour !';
						    	// Redirection page
						    	$nxView = new \Epi_Model\View();
							    $nxView->redirectView('account');
						    }
						    else
						    {
						    	// Message erreur
								throw new \Epi_Model\AppException('une erreur est survenue, veuillez recommencer !', 'account');
						    }
						}
					    else
					    {
					        // Message erreur
							throw new \Epi_Model\AppException('votre mot de passe n\'est pas conforme.', 'account');
						}
					}
					else
					{
						// Message erreur
						throw new \Epi_Model\AppException('les deux mots de passe ne correspondent pas !', 'account');
					}
				}
				else
				{
					// Message erreur
					throw new \Epi_Model\AppException('les deux mots de passes n\'ont pas été renseignés.', 'account');	
				}
			}
			else
			{
				throw new \Epi_Model\AppException('vous avez dépassé le temps d\'envoie du formulaire. Rechargez la page et validez !', 'account');
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
		try
		{
			//Ajout d'un TOKEN faille CSRF 
			$csrf = new \Epi_Model\SecuriteCsrf('contact');
			$contactToken = $csrf->verifToken(HOST.'contact');
			if ($contactToken)
			{	    
			    // Message
				if (isset($_POST['contactMessage']) AND !empty($_POST['contactMessage']))
			    {
			    	// Utilisateur enregistré
					if (isset($_POST['userId']) AND !empty($_POST['userId']))
				    {
				    	// Vérifier si le mail existe
						$userManager = new \Epi_Model\UserManager; 
					    $userExist = $userManager->existIdUser($_POST['userId']);
					    if ($userExist)
					    {
					    	// Récuperation idUser
							$nxUser = new \Epi_Model\User($userExist);
							$userName = $nxUser->getName();
							$userMail = $nxUser->getMail();
						}
						else
						{
							throw new \Epi_Model\AppException('votre Email n\'a pas été récupéré ! Vous pouvez me contactez à l\'adresse suivante : epi@pass-sport-nature.fr', 'contact');
						}
				    }

				    // Nouvel utilisateur
				    else
				    {
				    	if(isset($_POST['contactName']) AND !empty($_POST['contactName']) AND isset($_POST['contactMail'])AND !empty($_POST['contactMail']))
				    	{
				    		$userName = $_POST['contactName'];
							$userMail = $_POST['contactMail'];
				    	}
				    	else
				    	{
							throw new \Epi_Model\AppException('votre Nom ou Email n\'a pas été récupéré, veuillez recommencer !', 'contact');
				    	}
				    }

				    // Envoie MESSAGE / Email
					$userMessage = $_POST['contactMessage'];

			    	$object = 'Message - Gestion EPI Pass\'Sport Nature';
			    	$to = "epi@pass-sport-nature.fr";
			    	$message = "
		                <h2>Nouveau Message</h2>
		                <div>
		                	<br>
			                <p>Bonjour,</p>
			                <p>Vous venez de recevoir un nouveau message sur la gestion des EPI :</p>
			               	<br>
							<p>Auteur : $userName</p>
			                <p>Mail : $userMail</p>
			                <br>
			                <p>Message : </p>
			                <p>$userMessage</p>
			                <br>
			            </div>
			    	";

			    	$nxEmail = new \Epi_Model\Email($object, $to, $message);
				    $nxEmail->sendEmail();

			    	// Message
					$_SESSION['message'] = 'Votre message a bien été envoyé ! Je vous recontacteria dans les plus bref délais ! ';
					// Redirection page
			    	$nxView = new \Epi_Model\View();
				    $nxView->redirectView('home');
			    }
			    else
		    	{
					throw new \Epi_Model\AppException('votre message n\'a pas été pris en compte , veuillez recommencer !', 'contact');
		    	}
		    }
			else
			{
				throw new \Epi_Model\AppException('vous avez dépassé le temps d\'envoie du formulaire de contact. Rechargez la page et validez votre message !', 'home');
			}
		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}

	}

}
