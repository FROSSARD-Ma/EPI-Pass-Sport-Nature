<?php
namespace Epi_Model;
use \PDO;

class KitManager extends Manager
{
    /*---  CREAT -------------------------------------------- */
    public function addKit($groupeId, $nxKit)
    {
        $sql ='INSERT INTO EPI_kits (kit_groupeId, kit_name)
            VALUES (:kit_groupeId, :kit_name)';
        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':kit_groupeId', $groupeId, PDO::PARAM_STR);
        $data->bindValue(':kit_name', $nxKit, PDO::PARAM_STR);
        $data->execute();  
        $kitId = $this->getPDO()->lastInsertId();
        return $kitId;
    }

    /*---  READ --------------------------------------------- */
    public function getKits()
    {
        $sql = 'SELECT *
                FROM EPI_kits 
                ORDER BY kit_name ASC';
        $datas = $this->reqSQL($sql);
        foreach ($datas as $data )
        {
            $kit = new \Epi_Model\Kit($data); // hydratation
            $kits[] = $kit; // Tableau d'objet
        }
        return $kits;
    }

    public function getKit($kitId)
    {
        $idKit = (int)$kitId;

        $sql = 'SELECT *
                FROM EPI_kits 
                WHERE kit_id = :idKit';

        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':idKit', $idKit, PDO::PARAM_STR);
        $data->execute(); 
        return $data;
    }

    /*---  UPDATE ------------------------------------------- */


    /*---  DELETE ------------------------------------------- */

}