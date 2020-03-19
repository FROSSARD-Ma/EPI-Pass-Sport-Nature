<?php
namespace Epi_Model;
use \PDO;

class EquipementManager extends Manager
{
    /*---  CREAT -------------------------------------------------------- */
    public function addEquipement()
    {
        $sql ='INSERT INTO EPI_equipement(eq_fabriquant,eq_modele,eq_reference,eq_serie,eq_taille,eq_matiere,eq_couleur,eq_marquage,eq_marquageLieu,eq_notice,eq_image,eq_statut,eq_fabrication,eq_achat,eq_utilisation,eq_rebutTheorique,eq_prochainControle,eq_frequenceControle,eq_groupeId,eq_categorieId,eq_kitId,eq_lotId)

        VALUES(:fabriquant,:modele,:reference,:serie,:taille,:matiere,:couleur,:marquage,:marquageLieu,:notice,:image,:statut,:fabrication,:achat,:utilisation,:rebutTheorique,:prochainControle,:frequenceControle,:groupeId,:categorieId,:kitId,:lotId)';
        
        $datas = $this->getPDO()->prepare($sql);
        
        $datas->bindValue(':fabriquant',    htmlspecialchars($_POST['fabriquant']), PDO::PARAM_STR);
        $datas->bindValue(':modele',        htmlspecialchars($_POST['modele']), PDO::PARAM_STR);
        $datas->bindValue(':reference',     htmlspecialchars($_POST['reference']), PDO::PARAM_STR);
        $datas->bindValue(':serie',         htmlspecialchars($_POST['serie']), PDO::PARAM_STR);
        $datas->bindValue(':taille',        htmlspecialchars($_POST['taille']), PDO::PARAM_STR);
        $datas->bindValue(':matiere',       htmlspecialchars($_POST['matiere']), PDO::PARAM_STR);
        $datas->bindValue(':couleur',       htmlspecialchars($_POST['couleur']), PDO::PARAM_STR);
        $datas->bindValue(':marquage',      htmlspecialchars($_POST['marquage']), PDO::PARAM_STR);
        $datas->bindValue(':marquageLieu',  htmlspecialchars($_POST['marquageLieu']), PDO::PARAM_STR);
        $datas->bindValue(':notice',        htmlspecialchars($_POST['notice']), PDO::PARAM_STR);
        $datas->bindValue(':image',         htmlspecialchars($_POST['image']), PDO::PARAM_STR);
        $datas->bindValue(':statut',        htmlspecialchars($_POST['statut']), PDO::PARAM_STR);
        // Dates
        $datas->bindValue(':fabrication',   htmlspecialchars($_POST['fabrication']), PDO::PARAM_STR);
        $datas->bindValue(':achat',         htmlspecialchars($_POST['achat']), PDO::PARAM_STR);
        $datas->bindValue(':utilisation',   htmlspecialchars($_POST['utilisation']), PDO::PARAM_STR);
        $datas->bindValue(':rebutTheorique',htmlspecialchars($_POST['rebutTheorique']), PDO::PARAM_STR);
        $datas->bindValue(':prochainControle',htmlspecialchars($_POST['prochainControle']), PDO::PARAM_STR);
        $datas->bindValue(':frequenceControle',htmlspecialchars($_POST['frequenceControle']), PDO::PARAM_STR);
        $datas->bindValue(':groupeId',      htmlspecialchars($_POST['groupeId']), PDO::PARAM_STR);
        $datas->bindValue(':categorieId',   htmlspecialchars($_POST['categorieId']), PDO::PARAM_STR);
        $datas->bindValue(':kitId',         htmlspecialchars($_POST['kitId']), PDO::PARAM_STR);
        $datas->bindValue(':lotId',         htmlspecialchars($_POST['lotId']), PDO::PARAM_STR);

        $datas->execute();  

        return $datas;
    }

    /*---  READ ---------------------------------------------------------- */
    public function getEquipement($id)
    {
        $idEq = (int)$id;

        $sql = 'SELECT * FROM EPI_equipement WHERE equipement_id =:idEq';

        $datas = $this->getPDO()->prepare($sql);
        $datas->bindValue(':idEq', $idEq, PDO::PARAM_STR);
        $datas->execute(); 
        
        return $datas;
    }

    /*---  UPDATE -------------------------------------------------------- */
    public function updateEquipement($id)
    {
        $idEq = (int)$id;

        $sql ='UPDATE EPI_equipement 
        SET eq_fabriquant=:fabriquant,eq_modele=:modele,eq_reference=:reference,eq_serie=:serie,eq_taille=:taille,eq_matiere=:matiere,eq_couleur=:couleur,eq_marquage=:marquage,eq_marquageLieu=:marquageLieu,eq_notice=:notice,eq_image=:image,eq_statut=:statut,eq_fabrication=:fabrication,eq_achat=:achat,eq_utilisation=:utilisation,eq_rebutTheorique=:rebutTheorique,eq_prochainControle=:prochainControle,eq_frequenceControle=:frequenceControle,eq_kitId=:kitId,eq_lotId=:lotId)
        WHERE  eq_id = :idEq';

        $datas = $this->getPDO()->prepare($sql);

        $datas->bindValue(':fabriquant',    htmlspecialchars($_POST['fabriquant']), PDO::PARAM_STR);
        $datas->bindValue(':modele',        htmlspecialchars($_POST['modele']), PDO::PARAM_STR);
        $datas->bindValue(':reference',     htmlspecialchars($_POST['reference']), PDO::PARAM_STR);
        $datas->bindValue(':serie',         htmlspecialchars($_POST['serie']), PDO::PARAM_STR);
        $datas->bindValue(':taille',        htmlspecialchars($_POST['taille']), PDO::PARAM_STR);
        $datas->bindValue(':matiere',       htmlspecialchars($_POST['matiere']), PDO::PARAM_STR);
        $datas->bindValue(':couleur',       htmlspecialchars($_POST['couleur']), PDO::PARAM_STR);
        $datas->bindValue(':marquage',      htmlspecialchars($_POST['marquage']), PDO::PARAM_STR);
        $datas->bindValue(':marquageLieu',  htmlspecialchars($_POST['marquageLieu']), PDO::PARAM_STR);
        $datas->bindValue(':notice',        htmlspecialchars($_POST['notice']), PDO::PARAM_STR);
        $datas->bindValue(':image',         htmlspecialchars($_POST['image']), PDO::PARAM_STR);
        $datas->bindValue(':statut',        htmlspecialchars($_POST['statut']), PDO::PARAM_STR);
        // Dates
        $datas->bindValue(':fabrication',   htmlspecialchars($_POST['fabrication']), PDO::PARAM_STR);
        $datas->bindValue(':achat',         htmlspecialchars($_POST['achat']), PDO::PARAM_STR);
        $datas->bindValue(':utilisation',   htmlspecialchars($_POST['utilisation']), PDO::PARAM_STR);
        $datas->bindValue(':rebutTheorique',htmlspecialchars($_POST['rebutTheorique']), PDO::PARAM_STR);
        $datas->bindValue(':prochainControle',htmlspecialchars($_POST['prochainControle']), PDO::PARAM_STR);
        $datas->bindValue(':frequenceControle',htmlspecialchars($_POST['frequenceControle']), PDO::PARAM_STR);

        $datas->bindValue(':kitId',         htmlspecialchars($_POST['kitId']), PDO::PARAM_STR);
        $datas->bindValue(':lotId',         htmlspecialchars($_POST['lotId']), PDO::PARAM_STR);
        
        $datas->bindValue(':idEq', $idEq, PDO::PARAM_STR); 
        $datas->execute();

        return $datas;
    }

    /*---  DELETE -------------------------------------------------------- */
    public function deleteEquipement($id)
    {
        $idEq = (int)$id;

        $sql ='DELETE FROM EPI_equipement WHERE eq_id = :idEq';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':idEq', $idEq, PDO::PARAM_STR);  
        $data->execute();
        
        return $data;
    }

}