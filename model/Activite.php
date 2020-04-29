<?php
namespace Epi_Model;

class Activite extends Manager
{
    private $_act_id;
    private $_act_name;
    private $_act_logo;

    public function __construct(array $dataSQL)
    {
        $this->hydrate($dataSQL);
    }

    // Un tableau de données (associatif) doit être passé à la fonction
    public function hydrate(array $dataSQL)
    {
        foreach ($dataSQL as $key => $value)
        {
            // Forcer Majuscule, supp 'activite_' = 9 caractères
            // On récupère le nom du setter correspondant à l'attribut
            $method = 'set' . ucfirst(substr($key,9));
            if (method_exists($this, $method))
            {
                $this->$method(htmlspecialchars($value));
            }
        }
    }

    // Liste des GETTERS --------------------------------------
    public function getId()
    { 
        return $this->_act_id; 
    }
    public function getName()
    { 
        return $this->_act_name; 
    }
    public function getLogo()
    { 
        return $this->_act_logo; 
    }
       
        
    // Liste des SETTERS ---------------------------------------

        public function setId($id)
        {
            // convertit l'argument en nombre entier.
            $id = (int) $id;
            
            if ($id > 0)
            {
                $this->_act_id = $id;
            }
        }
        public function setName($name)
        {
            if (is_string($name))
            {
              $this->_act_name = $name;
            }
        }
        public function setLogo($logo)
        {
            if (is_string($logo))
            {
              $this->_act_logo = $logo;
            }
        }
}
?>