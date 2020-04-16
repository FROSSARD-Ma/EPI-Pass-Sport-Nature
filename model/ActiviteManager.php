<?php
namespace Epi_Model;
use \PDO;

class ActiviteManager extends Manager
{
    /*---  CREAT -------------------------------------------- */
    public function addActivite($nxActivite)
    {
        $sql ='
            INSERT INTO EPI_activites (activite_name)
            VALUES (:activite_name)';
        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':activite_name', $nxActivite, PDO::PARAM_STR);
        $data->execute();  
        $activiteId = $this->getPDO()->lastInsertId();
        return $activiteId;
    }

    /*---  READ --------------------------------------------- */
    public function getActivites()
    {
        $sql = 'SELECT *
                FROM EPI_activites 
                ORDER BY activite_name ASC';
        $datas = $this->reqSQL($sql);
        foreach ($datas as $data )
        {
            $activite = new \Epi_Model\Activite($data); // hydratation
            $activites[] = $activite; // Tableau d'objet
        }
        return $activites;
    }

    /*---  UPDATE ------------------------------------------- */


    /*---  DELETE ------------------------------------------- */

}