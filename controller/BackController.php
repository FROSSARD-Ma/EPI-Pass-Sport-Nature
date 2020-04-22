<?php
namespace Epi_Controller;

class BackController
{
	// ---- CREAT  -------------------------------
	public function creatActivite($nxActivite)
	{
		try
		{
			$activiteManager = new \Epi_Model\ActiviteManager; 
			$creatActivite = $activiteManager->addActivite($nxActivite);
			if ($creatActivite)
			{
				return $creatActivite;
	        }
	        else
	        {
	        	throw new \Epi_Model\AppException('votre activité n\'a pas été créé', 'nxEquipt');
	        }
		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	public function creatCategorie($activiteId, $nxCategorie)
	{
		try
		{
			$categorieManager = new \Epi_Model\CategorieManager; 
			$creatCategorie = $categorieManager->addCategorie($activiteId, $nxCategorie);
			if ($creatCategorie)
			{
				return $creatCategorie;
	        }
	        else
	        {
	        	throw new \Epi_Model\AppException('votre catégorie n\'a pas été créé', 'nxEquipt');
	        }
		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	public function creatKit($groupeId, $nxKit)
	{
		try
		{
			$kitManager = new \Epi_Model\KitManager; 
			$creatKit = $kitManager->addKit($groupeId, $nxKit);
			if ($creatKit)
			{
				return $creatKit; // Id
	        }
	        else
	        {
	        	throw new \Epi_Model\AppException('votre kit n\'a pas été créé', 'nxEquipt');
	        }
		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	public function creatLot($groupeId, $nxLot)
	{
		try
		{
			$lotManager = new \Epi_Model\LotManager; 
			$creatLot = $lotManager->addLot($groupeId, $nxLot);
			if ($creatLot)
			{
				return $creatLot; // Id
	        }
	        else
	        {
	        	throw new \Epi_Model\AppException('votre lot n\'a pas été créé', 'nxEquipt');
	        }
		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	public function creatEquipt($params)
	{
		try
		{
			$csrf = new \Epi_Model\SecuriteCsrf('nxEquipt');
			$inscriptionToken = $csrf->verifToken(HOST.'nxEquipt');
			if ($inscriptionToken)
			{
				// ACTIVITE --------------
					if (($_POST['activiteId']=='nxActivite') AND (isset($_POST['nxActivite'])) AND !empty($_POST['nxActivite']))
					{
						$activiteId = $this->creatActivite($_POST['nxActivite']);
					}	    
				    else
			        {
			            $activiteId = $_POST['activiteId'];
			        }			
		        // CATEGORIE --------------
					if (($_POST['categorieId']=='nxCategorie') AND (isset($_POST['nxCategorie'])) AND !empty($_POST['nxCategorie']))
					{

						$categorieId = $this->creatCategorie($activiteId, $_POST['nxCategorie']);
					}	    
				    else
			        {
			            $categorieId = $_POST['categorieId'];
			        }
		        // KIT --------------------
					if (($_POST['kitId']=='nxKit') AND (isset($_POST['nxKit'])) AND !empty($_POST['nxKit']))
					{
						$kitId = $this->creatKit($_SESSION['groupeId'], $_POST['nxKit']);
					}	    
				    else
			        {
			            $kitId = $_POST['kitId'];
			        }
				// LOT --------------------
					if (($_POST['lotId']=='nxLot') AND (isset($_POST['nxLot'])) AND !empty($_POST['nxLot']))
					{
						$lotId = $this->creatLot($_SESSION['groupeId'], $_POST['nxLot']);
					}	    
				    else
			        {
			            $lotId = $_POST['lotId'];
			        }

				$EquipementManager = new \Epi_Model\EquipementManager; 
				$creatEquipt = $EquipementManager->addEquipement($_SESSION['groupeId'], $activiteId, $categorieId, $kitId, $lotId);
				if ($creatEquipt)
				{
					$_SESSION['message'] = 'Votre équipement est ajoutée !';
					// Nouvelle page 
					$nxView = new \Epi_Model\View();
					$nxView->redirectView('equipement/id/'.$creatEquipt);
				}
				else
				{
					throw new \Epi_Model\AppException('il y a eu un problème, l\'équipement n\'a pas été créé', 'nxEquipt');
				}
			}
			else
			{
				throw new \Epi_Model\AppException('vous avez dépassé le temps d\'envoie du formulaire. Rechargez la page et validez !', 'nxEquipt');
			}
		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	public function creatControl($params)
	{
		try
		{
			// Controle TOKEN Formulaire
			$csrf = new \Epi_Model\SecuriteCsrf('nxControl');
			$controleToken = $csrf->verifToken('nxControl');
			if ($controleToken)
			{
				extract($params); // recup $id de l'équipement dans url
				// Vérifier si Equipement existe 
				$equiptManager = new \Epi_Model\EquipementManager; 
			    $equiptExist = $equiptManager->existEquipt($id);
			    if ($equiptExist) 
			    {
					$controleManager = new \Epi_Model\ControleManager; 
					$creatControl = $controleManager->addControle($id, $_SESSION['userId']);
					if ($creatControl)
					{
						// Mettre à jour le statut de l'équipement
						$equipementManager = new \Epi_Model\EquipementManager;
				 		$upEquipt = $equipementManager->updateStatutEquipt($id, $_SESSION['groupeId']);
				 		if ($upEquipt)
					    {
							$_SESSION['message'] = 'Votre contrôle EPI est ajouté !';
							// Nouvelle page 
							$nxView = new \Epi_Model\View();
							$nxView->redirectView('equipement/id/'.$id);
						}
					    else
					    {
					    	// Message erreur
							throw new \Epi_Model\AppException('le statut de l\'équipement n\'a pas été mis à jour.', 'upEquipt/id/'.$id);
					    }	
			        }
			        else
			        {
			        	throw new \Epi_Model\AppException('votre controle EPI n\'a pas été créé', 'nxControl');
			        }
				}
				else
				{
					throw new \Epi_Model\AppException('l\'équipement n\'éxiste pas.', 'nxControl');
				}        
			}
			else
			{
				throw new \Epi_Model\AppException('vous avez dépassé le temps d\'envoie du formulaire. Rechargez la page et validez !', 'nxControl');
			}
			
		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	public function existDossier($dossier, $groupeId)
	{
		// --- TEST IMAGE -----------------------------------
		$dossierImg = 'public/img/'.$dossier.'/';
		$dossierImgGp = $dossierImg.'/'.$groupeId.'/';

		// Si le dossier du groupe n'existe pas, je le créée
		if (!file_exists($dossierImgGp))
		{
			if (mkdir($dossierImgGp, 0777, true))
			{
				return $dossierImgGp;
			}
			else
			{
				$_SESSION['message'] = 'Échec lors de la création du répertoire des images de votre compte. Une image par défaut a été ajoutée.';
			}
		}
		else
		{
			return $dossierImgGp;
		}
	}

	public function addImage($dossierImgGp)
	{
		$img = $_FILES['image'];
		// Test TAILLE image        
	    if ($img['size'] <= 1000000) // 1Mo
	    {
	        // Gestion Extentions
	        $extension_upload = strtolower(substr($img['name'], -4)); // récupère l'extention et la place en minuscule.
	        $extensions_autorise = array('.png', '.gif', '.jpg', '.jpeg');

	        if (in_array($extension_upload, $extensions_autorise))
	        {
	            //On formate le nom du fichier - suppression des accents
	            $fichier = strtr($img['name'],
	                  'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
	                  'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

	            // remplacer par expression rationnelle standard
	            $nomImage = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier); 
	            
	            if (move_uploaded_file($img['tmp_name'], $dossierImgGp.$nomImage))
	            {
	            	return $nomImage;
	            }
	            else
	            {
		            $error_types = array(
		            UPLOAD_ERR_FORM_SIZE=> "La taille de l'image téléchargée est trop importante.",
		            UPLOAD_ERR_PARTIAL  => "L'image a partiellement été téléchargée",
		            UPLOAD_ERR_NO_FILE  => "Pas d'image téléchargée"
		            );
		            throw new \Epi_Model\AppException($error_types[$_FILES['image']['error']], 'upEquipt');
		        }
	        }
	        else
	        {
	            throw new \Epi_Model\AppException('votre fichier n\'est pas une image', 'upEquipt');
	        }
	    }
	    else
	    { 
	        throw new \Epi_Model\AppException('Le fichier de l\'image est trop gros. Maximum 1 Mo', 'upEquipt');
	    }
	}

	//---- UPDATE -----------------------------------
	public function updateEquipt($params)
	{
		try
		{
			extract($params); // recup $id de l'équipement dans url

			// Vérifier si Equipement existe 
			$equiptManager = new \Epi_Model\EquipementManager; 
		    $equiptExist = $equiptManager->existEquipt($id);
		    if ($equiptExist) 
		    {
		    	$dossierImgGp = $this->existDossier('equipement', $_SESSION['groupeId']);	
//$nomImage = $this->addImage($dossierImgGp);
//echo $nomImage;exit;
				$equipementManager = new \Epi_Model\EquipementManager;
		 		$upEquipt = $equipementManager->updateEquipement($id, $_SESSION['groupeId'], $nomImage);
		 		if ($upEquipt)
			    {
			    	$_SESSION['message'] = 'L\'équipement a été mis à jour !';
					$nxView = new \Epi_Model\View();
					$nxView->redirectView('upEquipt/id/'.$id);
			    }
			    else
			    {
			    	// Message erreur
					throw new \Epi_Model\AppException('l\'équipement n\'a pas été mis à jour.', 'upEquipt/id/'.$id);
			    }
		 	}
			else
			{
				throw new \Epi_Model\AppException('l\'équipement n\'éxiste pas.', 'equipements');
			}

		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}
	}

	//---- DELETE -----------------------------------
	public function delEquipt($params)
	{
		try
		{
			extract($params); // recup $id de l'équipement dans url

			// Vérifier si Equipement existe 
			$equiptManager = new \Epi_Model\EquipementManager; 
		    $equiptExist = $equiptManager->existEquipt($id);
		    if ($equiptExist) 
		    {
		 		$equipementManager = new \Epi_Model\EquipementManager;

		 		$delEquipt = $equipementManager->deleteEquipement($id);	 		
		 		if ($delEquipt)
			    {
			    	$_SESSION['message'] = 'L\'équipement a été supprimé !';
					$nxView = new \Epi_Model\View();
					$nxView->redirectView('equipements');
			    }
			    else
			    {
			    	// Message erreur
					throw new \Epi_Model\AppException('l\'équipement n\'a pas été supprimé.', 'equipements');
			    }
			}
			else
		    {
		    	// Message erreur
				throw new \Epi_Model\AppException('l\'équipement n\'éxiste pas.', 'equipements');
		    }

		}
		catch (\Epi_Model\AppException $e)
		{
			$e->getRedirection();
		}

	}

}