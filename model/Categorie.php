<?php
namespace Epi_Model;

class Categorie extends Manager
{
    private $_cat_id;
    private $_cat_name;

    public function __construct(array $dataSQL)
    {
        $this->hydrate($dataSQL);
    }

    // Un tableau de données (associatif) doit être passé à la fonction
    public function hydrate(array $dataSQL)
    {
        foreach ($dataSQL as $key => $value)
        {
            // Forcer Majuscule, supp 'cat_' = 4 caractères
            // On récupère le nom du setter correspondant à l'attribut
            $method = 'set' . ucfirst(substr($key,4));
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
        return $this->_cat_id; 
    }
    public function getName()
    { 
        return $this->_cat_name; 
    }
       
        
    // Liste des SETTERS ---------------------------------------

        public function setId($id)
        {
            // convertit l'argument en nombre entier.
            $id = (int) $id;
            
            if ($id > 0)
            {
                $this->_cat_id = $id;
            }
        }
        public function setName($name)
        {
            if (is_string($name))
            {
              $this->_cat_name = $name;
            }
        }
}
?>