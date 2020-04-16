<?php
namespace Epi_Controller;

class BackController
{
	// ---- EQUIPEMENT  -------------------------------

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
	        	throw new \Epi_Model\AppException('votre activité n\'a pas été identifié', 'nxEquipt');
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
	        	throw new \Epi_Model\AppException('votre activité n\'a pas été identifié', 'nxEquipt');
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
			//Ajout d'un TOKEN faille CSRF 
			$csrf = new \Epi_Model\SecuriteCsrf('nxEquipt');
			$inscriptionToken = $csrf->verifToken(HOST.'nxEquipt');
			if ($inscriptionToken)
			{

				// ACTIVITE
				if (($_POST['activiteId']=='nxActivite') AND (isset($_POST['nxActivite'])) AND !empty($_POST['nxActivite']))
				{
					$activiteId = $this->creatActivite($_POST['nxActivite']);
				}	    
			    else
		        {
		            $activiteId = $_POST['activiteId'];
		        }			

		        // CATEGORIE
				if (($_POST['categorieId']=='nxCategorie') AND (isset($_POST['nxCategorie'])) AND !empty($_POST['nxCategorie']))
				{

					$categorieId = $this->creatCategorie($activiteId, $_POST['nxCategorie']);
				}	    
			    else
		        {
		            $categorieId = $_POST['categorieId'];
		        }


				//$kitId =
				//$lotId =

				$EquipementManager = new \Epi_Model\EquipementManager; 
				$creatEquipt = $EquipementManager->addEquipement($_SESSION['groupeId'], $activiteId, $categorieId, $kitId, $lotId);
				if ($creatEquipt)
				{
					$_SESSION['message'] = 'Votre équipement est ajoutée !';
					// Nouvelle page 
					$nxView = new \Epi_Model\View();
					$nxView->redirectView('equipement');
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

}