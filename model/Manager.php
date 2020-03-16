<?php 
namespace Epi_Model;
use \PDO;

class Manager {
  
    const BD_host='cl1-sql20.phpnet.org';
    const BD_name='rbb05301';
    const BD_user='rbb05301';
    const BD_pass='8ZoSzShHl1v4';

    private static $pdo;

    /* --------- CONNEXION BDD Manager ---------------------------- */
    public function getPDO() { // Retourne connexion BDD
        try {
            if ($this->pdo === null) {  // Permet 1 seule connexion à la BDD
                $pdo = new PDO('mysql:host='.Manager::BD_host.';dbname='.Manager::BD_name.';charset=UTF8', Manager::BD_user, Manager::BD_pass);
                $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo = $pdo; 
            }
            return $this->pdo;
        }
        catch(PDOException $e) {
          echo "Echec de connexion à la base de donnée !";
        }
    }

    /* --------- REQUETES Manager ---------------------------------- */
    public function reqSQL($sql, $attributes = null, $one = false )
    {
        // TYPE Requete
        if ($attributes == null) { 
            $req = $this->getPDO()->query($sql); // Requete QUERY
        } else {  
            $req = $this->getPDO()->prepare($sql); // Requete PREPARE
            $req->execute($attributes);
        }

        // FETCH Result
        $req->setFetchMode(PDO::FETCH_ASSOC);

        if ($one) { 
            $results = $req->fetch(); // true result
        } else {
            $results = $req->fetchAll(); // false result
        }
        return $results;
    }
}