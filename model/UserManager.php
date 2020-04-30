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

    public function existIdUser($id)
    {
        $idUser = (int)$id;

        $sql ='SELECT *
            FROM EPI_users 
            WHERE user_id = ?';
        $data = $this->reqSQL($sql, array (htmlspecialchars($idUser)), $one = true);
        return $data;
    }

    /*---  CREAT ------------------------------------------- */
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

    public function creatPass()
    {
        // Génération d'un mot de passe aléatoire  de 8 caractères  
        $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789';
        $nb_lettres = strlen($chaine) - 1;
        $nwPass = '';
        for($i=0; $i < 8 ; $i++) // 8 caractères
        {
            $pos = mt_rand(0, $nb_lettres); 
            $car = $chaine[$pos]; 
            $nwPass .= $car;
        }
        return $nwPass;
    }
    
    /*---  READ ---------------------------------------------------------- */
    
    public function getGroupe($id)
    {
        $idGroupe = (int)$id;
        $sql =' SELECT *
                FROM EPI_groupes 
                WHERE groupe_id =?';
        $data = $this->reqSQL($sql, array ($idGroupe), $one = true);
        return $data;
    }


    public function getUser($id)
    {
        $idUser = (int)$id;

        $sql =' SELECT EPI_users.*, EPI_groupes.groupe_name
                FROM EPI_users 
                JOIN EPI_groupes
                     ON EPI_users.user_groupeId=EPI_groupes.groupe_id
                WHERE user_id =?';
        $data = $this->reqSQL($sql, array ($idUser), $one = true);
        return $data;
    }

    public function getUsers($groupeId)
    {       
        $idGroupe = (int)$groupeId;

        $sql ='SELECT *
            FROM EPI_users 
            WHERE user_groupeId = :id AND user_profile="on"';
        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':id', $idGroupe, PDO::PARAM_STR); 
        $data->execute();
        return $data;
    }

    /*---  UPDATE -------------------------------------------------------- */
    public function updateMail($id)
    {
        $idUser = (int)$id;

        $sql ='UPDATE EPI_users 
            SET user_mail=:mail, user_notification=:notification
            WHERE  user_id = :id';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':mail', htmlspecialchars($_POST['userMail']), PDO::PARAM_STR);
        $data->bindValue(':notification', $_POST['userNotification'], PDO::PARAM_STR);
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

    public function updateUser($id, $statut)
    {
        $idUser = (int)$id;

        $sql ='UPDATE EPI_users 
            SET user_statut = :statut
            WHERE  user_id = :id';

        $data = $this->getPDO()->prepare($sql); 
        $data->bindValue(':statut', htmlspecialchars($statut), PDO::PARAM_STR);
        $data->bindValue(':id', $idUser, PDO::PARAM_STR); 
        $data->execute();

        return $data;
    }

    public function profilUser($id)
    {
        $idUser = (int)$id;
        $profile = 'off';

        $sql ='UPDATE EPI_users 
            SET user_profile = :profile
            WHERE  user_id = :id';

        $data = $this->getPDO()->prepare($sql); 
        $data->bindValue(':profile', $profile, PDO::PARAM_STR);
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