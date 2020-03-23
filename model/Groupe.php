<?php
namespace Epi_Model;
use \DateTime;

class Groupe extends Manager
{
    private $_groupe_id;
    private $_groupe_date;
    private $_groupe_name;
    private $_groupe_mail;
    private $_groupe_statut;
    private $_groupe_notification;

    public function __construct(array $dataSQL)
    {
        $this->hydrate($dataSQL);
    }

    // Un tableau de données (associatif) doit être passé à la fonction
    public function hydrate(array $dataSQL)
    {
        foreach ($dataSQL as $key => $value)
        {
            // Forcer Majuscule, supp 'groupe_' = 7 caractères
            // On récupère le nom du setter correspondant à l'attribut
            $method = 'set' . ucfirst(substr($key,7));
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
        return $this->_groupe_id; 
    }
    public function getDate()
    { 
        return $this->_groupe_date; 
    }
    public function getName()
    { 
        return $this->_groupe_name; 
    }
    public function getMail()
    { 
        return $this->_groupe_mail;
    }
    public function getStatut()
    { 
        return $this->_groupe_statut; 
    }
    public function getNotification()
    {
        return $this->_groupe_notification;
    }
   
    
    // Liste des SETTERS ---------------------------------------

    public function setId($id)
    {
        // convertit l'argument en nombre entier.
        $id = (int) $id;
        
        if ($id > 0)
        {
            $this->_groupe_id = $id;
        }
    }
      
    public function setDate($dateCreated)
    {
        $date = new DateTime($dateCreated);
        $this->_groupe_date = $date->format('d-m-Y');
    }

    public function setName($name)
    {
        if (is_string($name))
        {
          $this->_groupe_name = $name;
        }
    }

    public function setMail($mail)
    {
        if (is_string($mail))
        {
          $this->_groupe_mail = $mail;
        }
    }

    public function setStatut($statut)
    {
        if (is_string($statut))
        {
          $this->_groupe_statut = $statut;
        }
    }

    public function setNotification($notification)
    {
        if (is_string($notification))
        {
          $this->_groupe_notification = $notification;
        }
    }
}
?>