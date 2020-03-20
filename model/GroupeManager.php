<?php
namespace Epi_Model;
use \PDO;

class GroupeManager extends Manager
{
    /*---  CREAT -------------------------------------------------------- */
    public function addGroupe()
    {
        $sql ='INSERT INTO EPI_groupes(groupe_name, groupe_mail, groupe_statut, groupe_notification)
            VALUES(:name, :mail, :statut, :notification)';
        $datas = $this->getPDO()->prepare($sql);
        $datas->bindValue(':title', htmlspecialchars($_POST['name']), PDO::PARAM_STR);
        $datas->bindValue(':mail', htmlspecialchars($_POST['mail']), PDO::PARAM_STR); 
        $datas->bindValue(':statut',htmlspecialchars($_POST['statut']), PDO::PARAM_STR);
        $datas->bindValue(':notification', htmlspecialchars($_POST['notification']), PDO::PARAM_STR); 
        $datas->execute();  

        return $datas;
    }

    /*---  READ ---------------------------------------------------------- */
    public function getGroupe($id)
    {
        $idGroupe = (int)$id;

        $sql = 'SELECT * FROM EPI_groupes WHERE groupe_id =:id';

        $datas = $this->getPDO()->prepare($sql);
        $datas->bindValue(':idGroupe', $idGroupe, PDO::PARAM_STR);
        $datas->execute(); 
        
        return $datas;
    }

    /*---  UPDATE -------------------------------------------------------- */
    public function updateGroupe($id)
    {
        $idGroupe = (int)$id;

        $sql ='UPDATE EPI_groupes 
            SET groupe_name = :name, groupe_mail=:mail, groupe_notification=:notification
            WHERE  groupe_id = :idGroupe';

        $datas = $this->getPDO()->prepare($sql);
        $datas->bindValue(':name',       htmlspecialchars($_POST['name']), PDO::PARAM_INT); 
        $datas->bindValue(':mail',     htmlspecialchars($_POST['mail']), PDO::PARAM_STR);
        $datas->bindValue(':notification',   $_POST['notification'], PDO::PARAM_STR);
        $datas->bindValue(':idGroupe', $idGroupe, PDO::PARAM_STR); 
        $datas->execute();

        return $datas;
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