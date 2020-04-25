<?php
namespace Epi_Model;
use \PDO;
use \DateTime;

class EquipementManager extends Manager
{
    /*---  CREAT -------------------------------------------------------- */
    public function addEquipement($groupeId, $activiteId, $categorieId, $kitId, $lotId)
    {
        // Calcul date de rebut Théorique
        $dureeAnnee = $_POST['dureeVie'];
        if (is_numeric($dureeAnnee))
        {
            $fabrication = new DateTime($_POST['fabrication']);
            $fabricationJour = $fabrication->getTimestamp();

            $dureeJour = $dureeAnnee*365;
            $dureeExpire = $dureeJour*24*3600;

            $dureeVie = $fabricationJour + $dureeExpire;
            $rebutTheorique = date("Y-m-d", $dureeVie);
        }
        else
        {
            $rebutTheorique = '';
        }

        // Calcul date du prochain controle
        $frequenceJour = $_POST['frequenceControle'];
        if (is_numeric($frequenceJour))
        {
            $utilisation = new DateTime($_POST['utilisation']);
            $utilisationJour = $utilisation->getTimestamp();

            $dureeExpire = $frequenceJour*24*3600;
            $dureeVie = $utilisationJour + $dureeExpire;
            $prochainControle = date("Y-m-d", $dureeVie);
        }
        else
        {
            $prochainControle = '';
        }

        // Insertion nouvel équipement
        $sql ='INSERT INTO EPI_equipement(eq_fabriquant,eq_modele,eq_reference,eq_serie,eq_taille,eq_matiereMetal,eq_matiereTextile,eq_matierePlastique,eq_fabrication,eq_achat,eq_utilisation,eq_statut,eq_dureeVie,eq_frequenceControle,eq_rebutTheorique,eq_prochainControle,eq_groupeId,eq_activiteId,eq_categorieId,eq_kitId,eq_lotId)

        VALUES(:fabriquant,:modele,:reference,:serie,:taille,:matiereMetal,:matiereTextile,:matierePlastique,:fabrication,:achat,:utilisation,:statut,:dureeVie,:frequenceControle,:rebutTheorique,:prochainControle,:groupeId,:activiteId,:categorieId,:kitId,:lotId)';
        
        $datas = $this->getPDO()->prepare($sql);
        
        $datas->bindValue(':fabriquant',    htmlspecialchars($_POST['fabriquant']), PDO::PARAM_STR);
        $datas->bindValue(':modele',        htmlspecialchars($_POST['modele']), PDO::PARAM_STR);
        $datas->bindValue(':reference',     htmlspecialchars($_POST['reference']), PDO::PARAM_STR);
        $datas->bindValue(':serie',         htmlspecialchars($_POST['serie']), PDO::PARAM_STR);
        $datas->bindValue(':taille',        htmlspecialchars($_POST['taille']), PDO::PARAM_STR);
        $datas->bindValue(':matiereMetal',  htmlspecialchars($_POST['matiereMetal']), PDO::PARAM_STR);
        $datas->bindValue(':matiereTextile',htmlspecialchars($_POST['matiereTextile']), PDO::PARAM_STR);
        $datas->bindValue(':matierePlastique',htmlspecialchars($_POST['matierePlastique']), PDO::PARAM_STR);
        // Dates
        $datas->bindValue(':fabrication',   htmlspecialchars($_POST['fabrication']), PDO::PARAM_STR);
        $datas->bindValue(':achat',         htmlspecialchars($_POST['achat']), PDO::PARAM_STR);
        $datas->bindValue(':utilisation',   htmlspecialchars($_POST['utilisation']), PDO::PARAM_STR);
        // Paramètres
        $datas->bindValue(':statut',        htmlspecialchars($_POST['statut']), PDO::PARAM_STR);
        $datas->bindValue(':dureeVie',      htmlspecialchars($_POST['dureeVie']), PDO::PARAM_STR);
        $datas->bindValue(':frequenceControle',htmlspecialchars($_POST['frequenceControle']), PDO::PARAM_STR);
        // Calcul automatique
        $datas->bindValue(':rebutTheorique', $rebutTheorique, PDO::PARAM_STR);
        $datas->bindValue(':prochainControle', $prochainControle, PDO::PARAM_STR);
        // Id
        $datas->bindValue(':groupeId',     $groupeId, PDO::PARAM_STR);
        $datas->bindValue(':activiteId',   $activiteId, PDO::PARAM_STR);
        $datas->bindValue(':categorieId',  $categorieId, PDO::PARAM_STR);
        $datas->bindValue(':kitId',        $kitId, PDO::PARAM_STR);
        $datas->bindValue(':lotId',        $lotId, PDO::PARAM_STR);

        $datas->execute();

        $lastInsertId = $this->getPDO()->lastInsertId();
        return $lastInsertId; 
    }

    /*---  READ ---------------------------------------------------------- */
    public function getEquipements($groupeId)
    {
        $idGroupe = (int)$groupeId;

        $sql = 'SELECT EPI_equipement.*, EPI_categories.cat_name, EPI_activites.activite_name

            FROM EPI_equipement 

                JOIN EPI_categories
                ON EPI_equipement.eq_categorieId=EPI_categories.cat_id

                JOIN EPI_activites
                ON EPI_equipement.eq_activiteId=EPI_activites.activite_id

            WHERE eq_groupeId =:idGroupe';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':idGroupe', $idGroupe, PDO::PARAM_STR);
        $data->execute(); 
        return $data;
    }

    public function getEquiptsInvalide($groupeId)
    {
        $idGroupe = (int)$groupeId;

        $sql = 'SELECT EPI_equipement.*, EPI_categories.cat_name, EPI_activites.activite_name

            FROM EPI_equipement 

                JOIN EPI_categories
                ON EPI_equipement.eq_categorieId=EPI_categories.cat_id

                JOIN EPI_activites
                ON EPI_equipement.eq_activiteId=EPI_activites.activite_id

            WHERE eq_groupeId =:idGroupe AND eq_statut !="Valide"
            ORDER BY EPI_equipement.eq_prochainControle ASC';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':idGroupe', $idGroupe, PDO::PARAM_STR);
        $data->execute(); 
        return $data;
    }

    public function existEquipt($equiptId)
    {
        $idEquipt = (int)$equiptId;

        $sql ='SELECT EPI_equipement.eq_id
            FROM EPI_equipement 
            WHERE eq_id = ?';
        $data = $this->reqSQL($sql, array ($idEquipt), $one = true);
        return $data;
    }

    public function countEquiptsStatut($statut)
    {
        $sql ='SELECT count(*)
            FROM EPI_equipement 
            WHERE eq_statut = ? AND eq_groupeId = ?';
        $count = $this->reqSQL($sql, array ($statut, $_SESSION['groupeId']), $one = true);
        $countEquiptsStatut = implode($count);
        return $countEquiptsStatut;
    }
    public function countControleRetard()
    {
        $today = date('Y-m-d');

        $sql ='SELECT count(*)
            FROM EPI_equipement 
            WHERE eq_prochainControle < ? AND eq_groupeId = ?';
        $count = $this->reqSQL($sql, array ($today, $_SESSION['groupeId']), $one = true);
        $countControleRetard = implode($count);
        return $countControleRetard;
    }

    public function getEquipement($equiptId)
    {
        $idEquipt = (int)$equiptId;

        $sql = 'SELECT EPI_equipement.*, EPI_categories.cat_name, EPI_activites.activite_name 
        -- , EPI_kits.kit_name, EPI_lots.lot_name

            FROM EPI_equipement 

                JOIN EPI_categories
                ON EPI_equipement.eq_categorieId=EPI_categories.cat_id

                JOIN EPI_activites
                ON EPI_equipement.eq_activiteId=EPI_activites.activite_id

                -- JOIN EPI_kits
                -- ON EPI_equipement.eq_kitId=EPI_kits.kit_id

                -- JOIN EPI_lots
                -- ON EPI_equipement.eq_lotId=EPI_lots.lot_id

            WHERE eq_id = ?';

        $datas = $this->reqSQL($sql, array ($idEquipt), $one = true);
        return $datas;
    }

    public function getImageEquipt($equiptId)
    {
        $idEquipt = (int)$equiptId;

        $sql = 'SELECT EPI_equipement.eq_image
            FROM EPI_equipement 
            WHERE eq_id = ?';
        $datas = $this->reqSQL($sql, array ($idEquipt), $one = true);
        $image = implode($datas);
        return $image;
    }
    

    /*---  UPDATE ----------------------------------------- */
    public function updateEquipement($equiptId, $groupeId, $nomImage)
    {
        $idEquipt = (int)$equiptId;
        $idGroupe = (int)$groupeId;

        $sql ='UPDATE EPI_equipement 
        SET eq_taille=:taille, eq_matiereMetal=:matiereMetal, eq_matiereTextile=:matiereTextile, eq_matierePlastique=:matierePlastique,eq_couleur=:couleur,eq_marquage=:marquage,eq_marquageLieu=:marquageLieu,eq_notice=:notice,eq_image=:image,eq_statut=:statut,eq_achat=:achat,eq_utilisation=:utilisation,eq_rebutTheorique=:rebutTheorique,eq_frequenceControle=:frequenceControle,eq_kitId=:kitId,eq_lotId=:lotId
        WHERE  eq_id = :idEquipt AND eq_groupeId = :idGroupe';

        $datas = $this->getPDO()->prepare($sql);

        $datas->bindValue(':taille', htmlspecialchars($_POST['taille']), PDO::PARAM_STR);
        $datas->bindValue(':matiereMetal', htmlspecialchars($_POST['matiereMetal']), PDO::PARAM_STR);
        $datas->bindValue(':matiereTextile', htmlspecialchars($_POST['matiereTextile']), PDO::PARAM_STR);
        $datas->bindValue(':matierePlastique', htmlspecialchars($_POST['matierePlastique']), PDO::PARAM_STR);
        $datas->bindValue(':couleur', htmlspecialchars($_POST['couleur']), PDO::PARAM_STR);
        $datas->bindValue(':marquage', htmlspecialchars($_POST['marquage']), PDO::PARAM_STR);
        $datas->bindValue(':marquageLieu', htmlspecialchars($_POST['marquageLieu']), PDO::PARAM_STR);
        $datas->bindValue(':notice', htmlspecialchars($_POST['noti  ce']), PDO::PARAM_STR);
        $datas->bindValue(':image', $nomImage, PDO::PARAM_STR);
        $datas->bindValue(':statut', htmlspecialchars($_POST['statut']), PDO::PARAM_STR);
        // Dates
        $datas->bindValue(':achat', htmlspecialchars($_POST['achat']), PDO::PARAM_STR);
        $datas->bindValue(':utilisation', htmlspecialchars($_POST['utilisation']), PDO::PARAM_STR);
        $datas->bindValue(':rebutTheorique', htmlspecialchars($_POST['rebutTheorique']), PDO::PARAM_STR);
        $datas->bindValue(':frequenceControle', htmlspecialchars($_POST['frequenceControle']), PDO::PARAM_STR);
        //Id
        $datas->bindValue(':kitId', htmlspecialchars($_POST['kitId']), PDO::PARAM_STR);  
        $datas->bindValue(':lotId', htmlspecialchars($_POST['lotId']), PDO::PARAM_STR);
        $datas->bindValue(':idEquipt', $idEquipt, PDO::PARAM_STR);
        $datas->bindValue(':idGroupe', $idGroupe, PDO::PARAM_STR);

        $datas->execute();
        return $datas;
    }

    public function updateStatutEquipt($equiptId, $groupeId)
    {
        $idEquipt = (int)$equiptId;
        $idGroupe = (int)$groupeId;
        
        $sql ='UPDATE EPI_equipement 
        SET eq_statut=:statut
        WHERE  eq_id = :idEquipt AND eq_groupeId = :idGroupe';
        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':statut', htmlspecialchars($_POST['statut']), PDO::PARAM_STR);
        $data->bindValue(':idEquipt', $idEquipt, PDO::PARAM_STR);
        $data->bindValue(':idGroupe', $idGroupe, PDO::PARAM_STR);
        $data->execute();
        return $data;
    }



    /*---  DELETE ----------------------------------------- */
    public function deleteEquipement($equiptId)
    {
        $idEquipt = (int)$equiptId;

        $sql ='DELETE FROM EPI_equipement WHERE eq_id = :idEquipt';
        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':idEquipt', $idEquipt, PDO::PARAM_STR);  
        $data->execute();
        return $data;
    }
}