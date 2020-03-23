<?php
namespace Epi_Model;
use \PDO;

class UserManager extends Manager
{
    /*---  CREAT -------------------------------------------------------- */
    public function addUser($groupeId)
    {
        $idGroupe = (int)$groupeId;

        $sql ='INSERT INTO EPI_users(user_groupeId, user_name, user_firstname, user_mail, user_pass, user_notification, user_statut)
            VALUES(:idGroupe,:name,:firstname:mail,:pass,:notification,:statut)';

        $datas = $this->getPDO()->prepare($sql);
        $datas->bindValue(':idGroupe', $idGroupe, PDO::PARAM_STR); 
        $datas->bindValue(':name', htmlspecialchars($_POST['name']), PDO::PARAM_STR);
        $datas->bindValue(':firstname', htmlspecialchars($_POST['firstname']), PDO::PARAM_STR);
        $datas->bindValue(':mail', htmlspecialchars($_POST['mail']), PDO::PARAM_STR);
        $datas->bindValue(':pass', htmlspecialchars($_POST['pass']), PDO::PARAM_STR);
        $datas->bindValue(':notification', htmlspecialchars($_POST['notification']), PDO::PARAM_STR); 
        $datas->bindValue(':statut',htmlspecialchars($_POST['statut']), PDO::PARAM_STR);
        $datas->execute();  

        return $datas;
    }

    /*---  READ ---------------------------------------------------------- */
    public function getUser($id)
    {
        $idUser = (int)$id;

        $sql = 'SELECT EPI_users.*, EPI_groupes.groupe_name

            FROM EPI_users 

                JOIN EPI_groupes
                     ON EPI_users.user_groupeId=EPI_groupes.groupe_id

            WHERE user_id =:id';

        $datas = $this->getPDO()->prepare($sql);
        $datas->bindValue(':id', $idUser, PDO::PARAM_STR);
        $datas->execute(); 
        
        return $datas;
    }

    /*---  UPDATE -------------------------------------------------------- */
    public function updateUser($id)
    {
        $idUser = (int)$id;

        $sql ='UPDATE EPI_users 
            SET user_mail=:mail, user_pass = :pass, user_notification=:notification, user_statut=:statut
            WHERE  user_id = :id';

        $datas = $this->getPDO()->prepare($sql);
        $datas->bindValue(':mail', htmlspecialchars($_POST['mail']), PDO::PARAM_STR);
        $datas->bindValue(':pass', htmlspecialchars($_POST['pass']), PDO::PARAM_STR);
        $datas->bindValue(':notification', $_POST['notification'], PDO::PARAM_STR);
        $datas->bindValue(':statut', htmlspecialchars($_POST['statut']), PDO::PARAM_STR);
        $datas->bindValue(':id', $idUser, PDO::PARAM_STR); 
        $datas->execute();

        return $datas;
    }

    /*---  DELETE -------------------------------------------------------- */
    public function deleteUser($id)
    {
        $idUser = (int)$id;

        $sql ='DELETE FROM EPI_users WHERE user_id = :id';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':id', $idUser, PDO::PARAM_STR);  
        $data->execute();
        
        return $data;
    }

}