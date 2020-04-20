<?php
namespace Epi_Model;
use \PDO;

class LotManager extends Manager
{
    /*---  CREAT -------------------------------------------- */
    public function addLot($groupeId, $nxLot)
    {
        $sql ='INSERT INTO EPI_lots (lot_groupeId, lot_name)
            VALUES (:lot_groupeId, :lot_name)';
        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':lot_groupeId', $groupeId, PDO::PARAM_STR);
        $data->bindValue(':lot_name', $nxLot, PDO::PARAM_STR);
        $data->execute();  
        $lotId = $this->getPDO()->lastInsertId();
        return $lotId;
    }

    /*---  READ --------------------------------------------- */
    public function getLots()
    {
        $sql = 'SELECT *
                FROM EPI_lots 
                ORDER BY lot_name ASC';
        $datas = $this->reqSQL($sql);
        foreach ($datas as $data )
        {
            $lot = new \Epi_Model\Lot($data); // hydratation
            $lots[] = $lot; // Tableau d'objet
        }
        return $lots;
    }

    public function getLot($lotId)
    {
        $idLot = (int)$lotId;

        $sql = 'SELECT *
                FROM EPI_lots 
                WHERE lot_id = :idLot';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':idLot', $idLot, PDO::PARAM_STR);
        $data->execute(); 
        return $data;
    }

    /*---  UPDATE ------------------------------------------- */


    /*---  DELETE ------------------------------------------- */

}