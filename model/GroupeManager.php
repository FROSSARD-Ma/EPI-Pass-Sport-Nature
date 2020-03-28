<?php
namespace Epi_Model;
use \PDO;

class GroupeManager extends Manager
{

    public function existGroupe($email)
    {
        $sql ='SELECT *
            FROM EPI_groupes 
            WHERE groupe_mail = ?';
        $data = $this->reqSQL($sql, array (htmlspecialchars($email)), $one = true);
        return $data;
    }

    /*---  CREAT -------------------------------------------------------- */
    public function addGroupe($groupeName, $groupeMail, $groupeStatut)
    {
        $sql ='INSERT INTO EPI_groupes(groupe_name, groupe_mail, groupe_statut)
            VALUES(:name, :mail, :statut)';
        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':name', htmlspecialchars($groupeName), PDO::PARAM_STR);
        $data->bindValue(':mail', htmlspecialchars($groupeMail), PDO::PARAM_STR); 
        $data->bindValue(':statut',htmlspecialchars($groupeStatut), PDO::PARAM_STR);
        $data->execute();

        $lastInsertId = $this->getPDO()->lastInsertId();
        return $lastInsertId;
    }

    /*---  READ ---------------------------------------------------------- */
    public function getGroupe($id)
    {
        $idGroupe = (int)$id;

        $sql = 'SELECT * FROM EPI_groupes WHERE groupe_id =:id';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':idGroupe', $idGroupe, PDO::PARAM_STR);
        $data->execute(); 
        
        return $data;
    }

    /*---  UPDATE -------------------------------------------------------- */
    public function updateGroupe($id)
    {
        $idGroupe = (int)$id;

        $sql ='UPDATE EPI_groupes 
            SET groupe_name = :name, groupe_mail=:mail, groupe_notification=:notification
            WHERE  groupe_id = :idGroupe';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':name',       htmlspecialchars($_POST['name']), PDO::PARAM_INT); 
        $data->bindValue(':mail',     htmlspecialchars($_POST['mail']), PDO::PARAM_STR);
        $data->bindValue(':notification',   $_POST['notification'], PDO::PARAM_STR);
        $data->bindValue(':idGroupe', $idGroupe, PDO::PARAM_STR); 
        $data->execute();

        return $data;
    }

    /*---  DELETE -------------------------------------------------------- */
    public function deleteGroupe($id)
    {
        $idGroupe = (int)$id;

        $sql ='DELETE FROM EPI_groupes WHERE groupe_id = :idGroupe';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':idGroupe', $idGroupe, PDO::PARAM_STR);  
        $data->execute();
        
        return $data;
    }

}