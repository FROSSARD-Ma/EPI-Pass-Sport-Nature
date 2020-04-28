<?php
namespace Epi_Model;
use \DateTime;

class Controle extends Manager
{
    private $_controle_id;
    private $_controle_date;
    private $_controle_visuel;
    private $_controle_fonctionnel;
    private $_controle_observations;
    private $_controle_image;
    private $_controle_equipementId;
    private $_controle_userId;

    // Jointures id Equipt
    private $_eq_reference;
    private $_eq_modele;
    private $_eq_statut;

    // Jointures id Controleur
    private $_user_name;
    private $_user_firstname;

    public function __construct(array $dataSQL)
    {
        $this->hydrate($dataSQL);
    }

    // Un tableau de données (associatif) doit être passé à la fonction
    public function hydrate(array $dataSQL)
    {
        foreach ($dataSQL as $key => $value)
        {
            // Forcer Majuscule, supp '' = 0 caractères
            // On récupère le nom du setter correspondant à l'attribut
            $method = 'set' . ucfirst(substr($key,0));
            if (method_exists($this, $method))
            {
                $this->$method(htmlspecialchars($value));
            }
        }
    }
    // Liste des GETTERS --------------------------------------
        public function getId()
        { 
            return $this->_controle_id; 
        }
        public function getDate()
        { 
            return $this->_controle_date; 
        }
        public function getVisuel()
        { 
            return $this->_controle_visuel; 
        }
        public function getFonctionnel()
        { 
            return $this->_controle_fonctionnel; 
        }
        public function getObservations()
        { 
            return $this->_controle_observations;
        }
        public function getImage()
        { 
            return $this->_controle_image; 
        }

        // Equipement
        public function getEquipementId()
        {
            return $this->_controle_equipementId;
        }
        public function getEqStatut()
        { 
            return $this->_eq_statut; 
        }

        public function getColorStatut()
        { 
            if($this->getEqStatut() == 'Valide') // timestamp
            {
                echo 'badge-success';
            }
            elseif($this->getEqStatut() == 'À réparer') // timestamp
            {
                echo 'badge-primary';
            }
            else
            { 
                echo 'badge-warning';
            }
        }
        
        public function getEqModele()
        { 
            return $this->_eq_modele; 
        }
        public function getEqReference()
        { 
            return $this->_eq_reference; 
        }

        // Controleur
        public function getUserId()
        { 
            return $this->_controle_userId; 
        }
        public function getUserName()
        { 
            return $this->_user_name; 
        }
        public function getUserFirstname()
        { 
            return $this->_user_firstname; 
        }
        
        
    // Liste des SETTERS ---------------------------------------

        public function setControle_id($id)
        {
            // convertit l'argument en nombre entier.
            $id = (int) $id;
            
            if ($id > 0)
            {
                $this->_controle_id = $id;
            }
        }
        public function setControle_date($dateCreated)
        { 
            $date = new DateTime($dateCreated);
            $this->_controle_date = $date->format('d-m-Y');
        }
        public function setControle_visuel($visuel)
        {
            if (is_string($visuel))
            {
              $this->_controle_visuel = $visuel;
            }
        }
        public function setControle_fonctionnel($fonctionnel)
        {
            if (is_string($fonctionnel))
            {
              $this->_controle_fonctionnel = $fonctionnel;
            }
        }
        public function setControle_observations($observations)
        {
            if (is_string($observations))
            {
              $this->_controle_observations = $observations;
            }
        }
        public function setControle_image($image)
        {
            if (is_string($image))
            {
              $this->_controle_image = $image;
            }
        }

        public function setControle_equipementId($equipementId)
        {
            $id = (int) $equipementId;
            
            if ($id > 0)
            {
                $this->_controle_equipementId = $id;
            }
        }
        public function SetEq_statut($statut)
        { 
            if (is_string($statut))
            {
                $this->_eq_statut = $statut;
            }
        }
        public function SetEq_modele($modele)
        { 
            if (is_string($modele))
            {
                $this->_eq_modele = $modele;
            }
        }
        public function SetEq_reference($reference)
        { 
            if (is_string($reference))
            {
                $this->_eq_reference = $reference;
            }
        }

        public function setControle_userId($userId)
        {
            $id = (int) $userId;
            
            if ($id > 0)
            {
                $this->_controle_userId = $id;
            }
        }
        public function setUser_name($name)
        {
            if (is_string($name))
            {
              $this->_user_name = $name;
            }
        }
        public function setUser_firstname($firstname)
        {
            if (is_string($firstname))
            {
              $this->_user_firstname = $firstname;
            }
        }
}
?>