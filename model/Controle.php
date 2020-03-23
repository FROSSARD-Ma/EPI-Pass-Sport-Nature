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

    // Jointures id
    private $_controle_equipCatName;
    private $_controle_userControle;
    
    public function __construct(array $dataSQL)
    {
        $this->hydrate($dataSQL);
    }

    // Un tableau de données (associatif) doit être passé à la fonction
    public function hydrate(array $dataSQL)
    {
        foreach ($dataSQL as $key => $value)
        {
            // Forcer Majuscule, supp 'controle_' = 9 caractères
            // On récupère le nom du setter correspondant à l'attribut
            $method = 'set' . ucfirst(substr($key,9));
            if (method_exists($this, $method))
            {
                if ($method == 'setContent')
                {
                    $this->$method($value);
                }
                else
                {
                    $this->$method(htmlspecialchars($value));
                }
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
        public function getEquipementId()
        {
            return $this->_controle_equipementId;
        }
        public function getUserId()
        { 
            return $this->_controle_userId; 
        }
        public function getEquipCatName()
        { 
            return $this->_controle_equipCatName; 
        }
        public function getUserControle()
        { 
            return $this->_controle_userControle; 
        }
        
        
    // Liste des SETTERS ---------------------------------------

        public function setId($id)
        {
            // convertit l'argument en nombre entier.
            $id = (int) $id;
            
            if ($id > 0)
            {
                $this->_controle_id = $id;
            }
        }
        public function SetDate($dateCreated)
        { 
            $date = new DateTime($dateCreated);
            $this->_controle_date = $date->format('d-m-Y');
        }
        public function setVisuel($visuel)
        {
            if (is_string($visuel))
            {
              $this->_controle_visuel = $visuel;
            }
        }
        public function setFonctionnel($fonctionnel)
        {
            if (is_string($fonctionnel))
            {
              $this->_controle_fonctionnel = $fonctionnel;
            }
        }
        public function setObservations($observations)
        {
            if (is_string($observations))
            {
              $this->_controle_observations = $observations;
            }
        }
        public function setImage($image)
        {
            if (is_string($image))
            {
              $this->_controle_image = $image;
            }
        }
        public function setEquipementId($equipementId)
        {
            $id = (int) $equipementId;
            
            if ($id > 0)
            {
                $this->_controle_equipementId = $id;
            }
        }
        public function setUserId($userId)
        {
            $id = (int) $userId;
            
            if ($id > 0)
            {
                $this->_controle_userId = $id;
            }
        }
        public function setEquipCatName($equipement)
        {
            if (is_string($equipement))
            {
              $this->_controle_equipCatName = $equipement;
            }
        }
        public function setUserControle($name)
        {
            if (is_string($name))
            {
              $this->_controle_userControle = $name;
            }
        }
}
?>