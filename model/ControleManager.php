<?php
namespace Epi_Model;
use \PDO;

class ControleManager extends Manager
{
    /*---  CREAT -------------------------------------------------------- */
    public function addControle($equipId, $userId)
    {
        $idEquipt = (int)$equipId;
        $idUser = (int)$userId;

        $sql ='INSERT INTO EPI_controles(controle_visuel, controle_fonctionnel, controle_observations, controle_image, controle_equipementId, controle_userId)
            VALUES(:visuel,:fonctionnel,:observations,:image,:idEquipt,:idUser)';

        $datas = $this->getPDO()->prepare($sql);
        $datas->bindValue(':visuel',htmlspecialchars($_POST['visuelControle']), PDO::PARAM_STR);
        $datas->bindValue(':fonctionnel',htmlspecialchars($_POST['fonctionnelControle']), PDO::PARAM_STR);
        $datas->bindValue(':observations',htmlspecialchars($_POST['observationControle']), PDO::PARAM_STR); 
        $datas->bindValue(':image',htmlspecialchars($_POST['imageControle']), PDO::PARAM_STR);
        $datas->bindValue(':idEquipt', $idEquipt, PDO::PARAM_STR);
        $datas->bindValue(':idUser', $idUser, PDO::PARAM_STR); 
        $datas->execute();
        return $datas;
    }

    /*---  READ ---------------------------------------------------------- */
    public function getControles($equipementId)
    {
        $idEquipement = (int)$equipementId;

        $sql = 'SELECT EPI_controles.*, EPI_users.user_name, EPI_users.user_firstname
            FROM EPI_controles
                JOIN EPI_equipement
                ON EPI_equipement.eq_id=EPI_controles.controle_equipementId

                JOIN EPI_users
                ON EPI_users.user_id=EPI_controles.controle_userId

            WHERE controle_equipementId=? 
            ORDER BY EPI_controles.controle_date DESC';
            
        $datas = $this->reqSQL($sql, array ($idEquipement));
        return $datas;
    }

    /*---  DELETE -------------------------------------------------------- */
    public function deleteControle($id)
    {
        $idControle = (int)$id;

        $sql ='DELETE FROM EPI_controles WHERE controle_id = :id';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':id', $idControle, PDO::PARAM_STR);  
        $data->execute();
        
        return $data;
    }

}