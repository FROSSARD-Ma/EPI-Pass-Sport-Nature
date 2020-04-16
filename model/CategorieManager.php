<?php
namespace Epi_Model;
use \PDO;

class CategorieManager extends Manager
{
    /*---  CREAT -------------------------------------------- */
    public function addCategorie($activiteId, $nxCategorie)
    {
        $sql ='
            INSERT INTO EPI_categories (cat_activiteId, cat_name)
            VALUES (:cat_activiteId, :cat_name)';
        $data = $this->getPDO()->prepare($sql);
        $data->bindValue(':cat_activiteId', $activiteId, PDO::PARAM_STR);
        $data->bindValue(':cat_name', $nxCategorie, PDO::PARAM_STR);
        $data->execute();
        $categorieId = $this->getPDO()->lastInsertId();
        return $categorieId;
    }

    /*---  READ --------------------------------------------- */
    public function getCategories()
    {
        $sql = 'SELECT *
                FROM EPI_categories 
                ORDER BY cat_name ASC';
        $datas = $this->reqSQL($sql);
        foreach ($datas as $data )
        {
            $categorie = new \Epi_Model\Categorie($data); // hydratation
            $categories[] = $categorie; // Tableau d'objet
        }
        return $categories;
    }

    /*---  UPDATE ------------------------------------------- */

    /*---  DELETE ------------------------------------------- */

}