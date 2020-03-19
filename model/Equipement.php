<?php
namespace Epi_Model;
use \DateTime;

class Equipement extends Manager
{
    private $_eq_id;
    private $_eq_fabriquant;
    private $_eq_modele;
    private $_eq_reference;
    private $_eq_serie;
    private $_eq_taille;
    private $_eq_matiere;
    private $_eq_couleur;
    private $_eq_marquage;
    private $_eq_marquageLieu;
    private $_eq_notice;
    private $_eq_image;
    private $_eq_statut;

    // Dates
    private $_eq_fabrication;
    private $_eq_achat;
    private $_eq_utilisation;
    private $_eq_rebutTheorique;
    private $_eq_prochainControle;
    private $_eq_frequenceControle;

    // Lien ID
    // private $_eq_groupeId;
    // private $_eq_categorieId;
    // private $_eq_kitId;
    // private $_eq_lotId;

    private $_eq_groupe;
    private $_eq_activite;
    private $_eq_categorie;
    private $_eq_kit;
    private $_eq_lot;


    public function __construct(array $dataSQL)
    {
        $this->hydrate($dataSQL);
    }

    // Un tableau de données (associatif) doit être passé à la fonction
    public function hydrate(array $dataSQL)
    {
        foreach ($dataSQL as $key => $value)
        {
            // Forcer Majuscule, supp 'eq_' = 3 caractères
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
            return $this->_eq_id; 
        }
        public function getFabriquant()
        { 
            return $this->_eq_fabriquant; 
        }
        public function getModele()
        { 
            return $this->_eq_modele; 
        }
        public function getReference()
        { 
            return $this->_eq_reference; 
        }
        public function getSerie()
        { 
            return $this->_eq_serie;
        }
        public function getTaille()
        { 
            return $this->_eq_taille; 
        }
        public function getMatiere()
        {
            return $this->_eq_matiere;
        }
        public function getCouleur()
        { 
            return $this->_eq_couleur; 
        }
        public function getMarquage()
        { 
            return $this->_eq_marquage; 
        }
        public function getMarquageLieu()
        { 
            return $this->_eq_marquageLieu; 
        }
        public function getNotice()
        { 
            return $this->_eq_notice; 
        }
        public function getImage()
        { 
            return $this->_eq_image; 
        }
        public function getStatut()
        { 
            return $this->_eq_statut; 
        }

        // Dates
        public function getFabrication()
        { 
            return $this->_eq_fabrication; 
        }
        public function getAchat()
        { 
            return $this->_eq_achat; 
        }
        public function getUtilisation()
        { 
            return $this->_eq_utilisation; 
        }
        public function getRebutTheorique()
        { 
            return $this->_eq_rebutTheorique; 
        }
        public function getProchainControle()
        { 
            return $this->_eq_prochainControle; 
        }
        public function getFrequenceControle()
        { 
            return $this->_eq_frequenceControle; 
        }

        //  Lien infos
        public function getGroupe()
        { 
            return $this->_eq_groupe; 
        }
        public function getActivite()
        { 
            return $this->_eq_activite; 
        }
        public function getCategorie()
        { 
            return $this->_eq_categorie; 
        }
        public function getKit()
        { 
            return $this->_eq_kit; 
        }
        public function getLot()
        { 
            return $this->_eq_lot; 
        }
       
        
    // Liste des SETTERS ---------------------------------------

        public function setId($id)
        {
            // convertit l'argument en nombre entier.
            $id = (int) $id;
            
            if ($id > 0)
            {
                $this->_eq_id = $id;
            }
        }
        public function setFabriquant($fabriquant)
        {
            if (is_string($fabriquant))
            {
              $this->_eq_fabriquant = $fabriquant;
            }
        }
        public function setModele($modele)
        {
            if (is_string($modele))
            {
              $this->_eq_modele = $modele;
            }
        }
        public function setReference($reference)
        {
            if (is_string($reference))
            {
              $this->_eq_reference = $reference;
            }
        }
        public function setSerie($serie)
        {
            if (is_string($serie))
            {
              $this->_eq_serie = $serie;
            }
        }
        public function setTaille($taille)
        {
            if (is_string($taille))
            {
              $this->_eq_taille = $taille;
            }
        }
        public function setMatiere($matiere)
        {
            if (is_string($matiere))
            {
              $this->_eq_matiere = $matiere;
            }
        }
        public function setcouleur($couleur)
        {
            if (is_string($couleur))
            {
              $this->_eq_couleur = $couleur;
            }
        }
        public function setMarquage($marquage)
        {
            if (is_string($marquage))
            {
              $this->_eq_marquage = $marquage;
            }
        }
        public function setMarquageLieu($marquageLieu)
        {
            if (is_string($marquageLieu))
            {
              $this->_eq_marquageLieu = $marquageLieu;
            }
        }
        public function setNotice($notice)
        {
            if (is_string($notice))
            {
              $this->_eq_notice = $notice;
            }
        }
        public function setImage($image)
        {
            if (is_string($image))
            {
              $this->_eq_image = $image;
            }
        }
        public function setStatut($statut)
        {
            if (is_string($statut))
            {
              $this->_eq_statut = $statut;
            }
        }

        // Dates

        public function SetFabrication($dateCreated)
        { 
            $date = new DateTime($dateCreated);
            $this->_eq_fabrication = $date->format('d-m-Y');
        }
        public function SetAchat($dateCreated)
        { 
            $date = new DateTime($dateCreated);
            $this->_eq_achat = $date->format('d-m-Y');
        }
        public function SetUtilisation($dateCreated)
        { 
             $date = new DateTime($dateCreated);
            $this->_eq_utilisation = $date->format('d-m-Y');
        }
        public function SetRebutTheorique($dateCreated)
        { 
            $date = new DateTime($dateCreated);
            $this->_eq_rebutTheorique = $date->format('d-m-Y');
        }
        public function SetProchainControle($dateCreated)
        { 
            $date = new DateTime($dateCreated);
            $this->_eq_prochainControle = $date->format('d-m-Y');
        }
        public function SetFrequenceControle($dateCreated)
        { 
            $date = new DateTime($dateCreated);
            $this->_eq_frequenceControle = $date->format('d-m-Y');
        }

        //  Lien infos
        public function SetGroupe($groupe)
        {
            if (is_string($groupe))
            {
                $this->_eq_groupe = $groupe; 
            }
        }
        public function SetActivite($activite)
        { 
            if (is_string($activite))
            {
                $this->_eq_activite = $activite; 
            }
        }
        public function SetCategorie($categorie)
        {
            if (is_string($categorie))
            { 
                $this->_eq_categorie = $categorie; 
            }
        }
        public function SetKit($kit)
        {
            if (is_string($kit))
            { 
                $this->_eq_kit = $kit; 
            }
        }
        public function SetLot($lot)
        {
            if (is_string($lot))
            { 
                $this->_eq_lot = $lot; 
            }   
        }

}
?>