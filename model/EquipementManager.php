<?php
namespace Epi_Model;
use \PDO;

class EquipementManager extends Manager
{
    /*---  CREAT -------------------------------------------------------- */
    public function addEquipement($groupeId, $activiteId, $categorieId, $kitId, $lotId)
    {
        $sql ='INSERT INTO EPI_equipement(eq_fabriquant, eq_modele, eq_reference, eq_serie, eq_taille, eq_matiereMetal, eq_matiereTextile, eq_matierePlastique, eq_fabrication, eq_groupeId, eq_activiteId, eq_categorieId, eq_kitId, eq_lotId)

        VALUES(:fabriquant,:modele,:reference,:serie,:taille,:matiereMetal, :matiereTextile, :matierePlastique,:fabrication,:groupeId,:activiteId,:categorieId,:kitId,:lotId)';
        
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
        // Id
        $datas->bindValue(':groupeId',     htmlspecialchars($groupeId), PDO::PARAM_STR);
        $datas->bindValue(':activiteId',   htmlspecialchars($activiteId), PDO::PARAM_STR);
        $datas->bindValue(':categorieId',  htmlspecialchars($categorieId), PDO::PARAM_STR);
        $datas->bindValue(':kitId',        htmlspecialchars($kitId), PDO::PARAM_STR);
        $datas->bindValue(':lotId',        htmlspecialchars($lotId), PDO::PARAM_STR);

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

    public function existEquipt($equiptId)
    {
        $idEquipt = (int)$equiptId;

        $sql ='SELECT EPI_equipement.eq_id
            FROM EPI_equipement 
            WHERE eq_id = ?';
        $data = $this->reqSQL($sql, array ($idEquipt), $one = true);
        return $data;
    }

    public function getEquipement($equiptId)
    {
        $idEquipt = (int)$equiptId;

        $sql = 'SELECT EPI_equipement.*, EPI_categories.cat_name, EPI_activites.activite_name

            FROM EPI_equipement 

                JOIN EPI_categories
                ON EPI_equipement.eq_categorieId=EPI_categories.cat_id

                JOIN EPI_activites
                ON EPI_equipement.eq_activiteId=EPI_activites.activite_id

            WHERE eq_id = ?';

        $datas = $this->reqSQL($sql, array ($idEquipt), $one = true);
        return $datas;
    }

    /*---  UPDATE ----------------------------------------- */
    public function updateEquipement($equiptId)
    {
        if (!empty($_FILES['image']['name']))
        {
            // Controle du chargement de l'imag
            include 'views/uploadImage.php';
        } 
        else 
        {
            $nomImage = 'equipement.png';
        }

        $idEquipt = (int)$equiptId;

        $sql ='UPDATE EPI_equipement 
        SET eq_taille=:taille, eq_matiereMetal=:matiereMetal, eq_matiereTextile=:matiereTextile, eq_matierePlastique=:matierePlastique,eq_couleur=:couleur,eq_marquage=:marquage,eq_marquageLieu=:marquageLieu,eq_notice=:notice,eq_image=:image,eq_statut=:statut,eq_fabrication=:fabrication,eq_achat=:achat,eq_utilisation=:utilisation,eq_rebutTheorique=:rebutTheorique,eq_frequenceControle=:frequenceControle,eq_kitId=:kitId,eq_lotId=:lotId
        WHERE  eq_id = :idEquipt AND eq_groupeId = :idGroupe';

        $datas = $this->getPDO()->prepare($sql);

        $datas->bindValue(':taille', htmlspecialchars($_POST['taille']), PDO::PARAM_STR);
        $datas->bindValue(':matiereMetal', htmlspecialchars($_POST['matiereMetal']), PDO::PARAM_STR);
        $datas->bindValue(':matiereTextile', htmlspecialchars($_POST['matiereTextile']), PDO::PARAM_STR);
        $datas->bindValue(':matierePlastique', htmlspecialchars($_POST['matierePlastique']), PDO::PARAM_STR);
        $datas->bindValue(':couleur', htmlspecialchars($_POST['couleur']), PDO::PARAM_STR);
        $datas->bindValue(':marquage', htmlspecialchars($_POST['marquage']), PDO::PARAM_STR);
        $datas->bindValue(':marquageLieu', htmlspecialchars($_POST['marquageLieu']), PDO::PARAM_STR);
        $datas->bindValue(':notice', htmlspecialchars($_POST['notice']), PDO::PARAM_STR);
        $datas->bindValue(':image', $nomImage, PDO::PARAM_STR);
        $datas->bindValue(':statut', htmlspecialchars($_POST['statut']), PDO::PARAM_STR);
        // Dates
        $datas->bindValue(':fabrication', htmlspecialchars($_POST['fabrication']), PDO::PARAM_STR);
        $datas->bindValue(':achat', htmlspecialchars($_POST['achat']), PDO::PARAM_STR);
        $datas->bindValue(':utilisation', htmlspecialchars($_POST['utilisation']), PDO::PARAM_STR);
        $datas->bindValue(':rebutTheorique', htmlspecialchars($_POST['rebutTheorique']), PDO::PARAM_STR);
        $datas->bindValue(':frequenceControle', htmlspecialchars($_POST['frequenceControle']), PDO::PARAM_STR);
        //Id
        $datas->bindValue(':kitId', htmlspecialchars($_POST['kitId']), PDO::PARAM_STR);
        $datas->bindValue(':lotId', htmlspecialchars($_POST['lotId']), PDO::PARAM_STR);
        $datas->bindValue(':idEquipt', $idEquipt, PDO::PARAM_STR);
        $datas->bindValue(':idGroupe', $SESSION['groupeId'], PDO::PARAM_STR);

        $datas->execute();

        $lastInsertId = $this->getPDO()->lastInsertId();
        return $lastInsertId; 
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