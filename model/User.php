<?php
namespace Epi_Model;
use \DateTime;

class User extends Manager
{
    private $_user_id;
    private $_user_name;
    private $_user_firstname;
    private $_user_mail;
    private $_user_pass;
    private $_user_notification;
    private $_user_statut;
    private $_user_inscription;
    private $_user_groupeId;

    // Jointures id
    private $_user_groupe;


    public function __construct(array $dataSQL)
    {
        $this->hydrate($dataSQL);
    }

    // Un tableau de données (associatif) doit être passé à la fonction
    public function hydrate(array $dataSQL)
    {
        foreach ($dataSQL as $key => $value)
        {
            // Forcer Majuscule, supp 'user_' = 5 caractères
            // On récupère le nom du setter correspondant à l'attribut
            $method = 'set' . ucfirst(substr($key,5));
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
        return $this->_user_id; 
    }
    public function getGroupeId()
    { 
        return $this->_user_groupeId; 
    }
    public function getName()
    { 
        return $this->_user_name; 
    }
    public function getFirstname()
    { 
        return $this->_user_firstname; 
    }
    public function getMail()
    { 
        return $this->_user_mail;
    }
    public function getPass()
    { 
        return $this->_user_pass; 
    }
    public function getNotification()
    {
        return $this->_user_notification;
    }
    public function getStatut()
    { 
        return $this->_user_statut; 
    }
    public function getInscription()
    { 
        return $this->_user_inscription; 
    }
    public function getGroupe()
    { 
        return $this->_user_groupe; 
    }
   
    
    // Liste des SETTERS ---------------------------------------

    public function setId($id)
    {
        // convertit l'argument en nombre entier.
        $id = (int) $id;
        
        if ($id > 0)
        {
            $this->_user_id = $id;
        }
    }
    public function setGroupeId($id)
    {
        // convertit l'argument en nombre entier.
        $id = (int) $id;
        
        if ($id > 0)
        {
            $this->_user_groupeId = $id;
        }
    }
    public function setName($name)
    {
        if (is_string($name))
        {
          $this->_user_name = $name;
        }
    }
    public function setFirstname($firstname)
    {
        if (is_string($firstname))
        {
          $this->_user_firstname = $firstname;
        }
    }
    public function setMail($mail)
    {
        if (is_string($mail))
        {
          $this->_user_mail = $mail;
        }
    }
    public function setPass($pass)
    {
        if (is_string($pass))
        {
          $this->_user_pass = $pass;
        }
    }
    public function setNotification($notification)
    {
        if (is_string($notification))
        {
          $this->_user_notification = $notification;
        }
    }
    public function setStatut($statut)
    {
        if (is_string($statut))
        {
          $this->_user_statut = $statut;
        }
    }
    public function setInscription($dateCreated)
    {
        $date = new DateTime($dateCreated);
        $this->_user_inscription = $date->format('d-m-Y');
    }
    public function setE_name ($groupe) // Groupe name Pb hydratation
    {
        if (is_string($groupe))
        {
          $this->_user_groupe = $groupe;
        }
    }
}
?>