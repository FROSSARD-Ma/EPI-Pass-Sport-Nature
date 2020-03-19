<?php
namespace Epi_Model;
use \PDO;

class ControleManager extends Manager
{
    /*---  CREAT -------------------------------------------------------- */
    public function addControle($equipementId, $userId)
    {
        $idEquipement = (int)$equipementId;
        $idUser = (int)$userId;

        $sql ='INSERT INTO EPI_controles(controle_visuel, controle_fonctionnel, controle_observations, controle_image, controle_equipementId, controle_userId)
            VALUES(:visuel,:fonctionnel:observations,:image,:idEquipement,:idUser)';

        $datas = $this->getPDO()->prepare($sql);
        
        $datas->bindValue(':visuel',htmlspecialchars($_POST['visuel']), PDO::PARAM_STR);
        $datas->bindValue(':fonctionnel',htmlspecialchars($_POST['fonctionnel']), PDO::PARAM_STR);
        $datas->bindValue(':observations',htmlspecialchars($_POST['observations']), PDO::PARAM_STR); 
        $datas->bindValue(':image',htmlspecialchars($_POST['image']), PDO::PARAM_STR);
        $datas->bindValue(':idEquipement', $idEquipement, PDO::PARAM_STR);
        $datas->bindValue(':idUser', $idUser, PDO::PARAM_STR); 

        $datas->execute();  

        return $datas;
    }

    /*---  READ ---------------------------------------------------------- */
    public function getControle($id)
    {
        $idControle = (int)$id;

        $sql = 'SELECT * FROM EPI_controles WHERE controle_id =:id';

        $datas = $this->getPDO()->prepare($sql);
        $datas->bindValue(':id', $idControle, PDO::PARAM_STR);
        $datas->execute(); 
        
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