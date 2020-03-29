<?php
namespace Epi_Model;
use \PDO;

class UserManager extends Manager
{

    public function existUser($email)
    {
        $sql ='SELECT *
            FROM EPI_users 
            WHERE user_mail = ?';
        $data = $this->reqSQL($sql, array (htmlspecialchars($email)), $one = true);
        return $data;
    }

    /*---  CREAT -------------------------------------------------------- */
    public function addUser($groupeId, $nxPassCrypt)
    {
        $idGroupe = (int)$groupeId;

        $sql ='INSERT INTO EPI_users(user_groupeId, user_name, user_firstname, user_mail, user_pass, user_statut)
            VALUES(:idGroupe,:name,:firstname,:mail,:pass,:statut)';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':idGroupe', $idGroupe, PDO::PARAM_STR); 
        $data->bindValue(':name', htmlspecialchars($_POST['userName']), PDO::PARAM_STR);
        $data->bindValue(':firstname', htmlspecialchars($_POST['userFirstname']), PDO::PARAM_STR);
        $data->bindValue(':mail', htmlspecialchars($_POST['userMail']), PDO::PARAM_STR);
        $data->bindValue(':pass', htmlspecialchars($nxPassCrypt), PDO::PARAM_STR);
        $data->bindValue(':statut',htmlspecialchars($_POST['userStatut']), PDO::PARAM_STR);
        $data->execute();  

        return $data;
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

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':id', $idUser, PDO::PARAM_STR);
        $data->execute(); 
        
        return $data;
    }

    /*---  UPDATE -------------------------------------------------------- */
    public function updateUser($id)
    {
        $idUser = (int)$id;

        $sql ='UPDATE EPI_users 
            SET user_mail=:mail, user_pass = :pass, user_notification=:notification, user_statut=:statut
            WHERE  user_id = :id';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':mail', htmlspecialchars($_POST['mail']), PDO::PARAM_STR);
        $data->bindValue(':pass', htmlspecialchars($_POST['pass']), PDO::PARAM_STR);
        $data->bindValue(':notification', $_POST['notification'], PDO::PARAM_STR);
        $data->bindValue(':statut', htmlspecialchars($_POST['statut']), PDO::PARAM_STR);
        $data->bindValue(':id', $idUser, PDO::PARAM_STR); 
        $data->execute();

        return $data;
    }
     public function updatePass($id, $nxPass)
    {
        $idUser = (int)$id;

        $sql ='UPDATE EPI_users 
            SET user_pass = :pass
            WHERE  user_id = :id';

        $data = $this->getPDO()->prepare($sql); 
        $data->bindValue(':pass', $nxPass, PDO::PARAM_STR);
        $data->bindValue(':id', $idUser, PDO::PARAM_STR); 
        $data->execute();

        return $data;
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