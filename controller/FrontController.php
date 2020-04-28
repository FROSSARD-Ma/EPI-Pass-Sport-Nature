<?php
namespace Epi_Controller;

class FrontController
{
    /* TOP Menu ----------------------------------- */
    public function home($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('login');
        $token = $csrf->getToken();

        $nxView = new \Epi_Model\View('home');
        $nxView->getView();
    }
    public function contact($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('contact');
        $token = $csrf->getToken();

        $nxView = new \Epi_Model\View('contact');
        $nxView->getView();
    }

    public function dashboard($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('dashboard');
        $token = $csrf->getToken();

        /* Count STATUT */
        $equipementManager = new \Epi_Model\EquipementManager;
        $equiptControle = $equipementManager->countEquiptsStatut('À contrôler');
        $_SESSION['countEquiptControler'] = $equiptControle;
        $equiptReparation = $equipementManager->countEquiptsStatut('À réparer');
        $_SESSION['countEquiptReparer'] = $equiptReparation;
        $equiptValide = $equipementManager->countEquiptsStatut('Valide');
        $_SESSION['countEquiptValide'] = $equiptValide;
        // Retard
        $controlRetard = $equipementManager->countControleRetard(); // today
        $_SESSION['countControleRetard'] = $controlRetard; 

        /* Liste USERS */
        $UserManager = new \Epi_Model\UserManager;
        $dataUsers = $UserManager->getUsers($_SESSION['groupeId']);
        foreach ($dataUsers as $data)
        {
            $user = new \Epi_Model\User($data);
            $users[] = $user; // Tableau d'objet
        }

        $nxView = new \Epi_Model\View('dashboard');
        $nxView->getView(array (
            'userResp'=> $userResp,
            'users'=> $users
        ));
    }

    public function equipements($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('equipements');
        $token = $csrf->getToken();

        /* Count STATUT */
        $equipementManager = new \Epi_Model\EquipementManager;
        $equiptControle = $equipementManager->countEquiptsStatut('À contrôler');
        $_SESSION['countEquiptControler'] = $equiptControle;
        $equiptReparation = $equipementManager->countEquiptsStatut('À réparer');
        $_SESSION['countEquiptReparer'] = $equiptReparation;
        $equiptValide = $equipementManager->countEquiptsStatut('Valide');
        $_SESSION['countEquiptValide'] = $equiptValide;
        // Retard
        $controlRetard = $equipementManager->countControleRetard(); // today
        $_SESSION['countControleRetard'] = $controlRetard; 

        /* Liste Equipements */
        $equipementManager = new \Epi_Model\EquipementManager;
        $dataEquipts = $equipementManager->getEquipements($_SESSION['groupeId']);
        foreach ($dataEquipts as $data)
        {
            $equipt = new \Epi_Model\Equipement($data);
            $equipts[] = $equipt; // Tableau d'objet
        }
        $nxView = new \Epi_Model\View('equipements');
        $nxView->getView(array (
            'equipts'=> $equipts));
    }

    public function equipement($params)
    {
        extract($params); // id equipement
        
        // Vérifier si Equipement existe 
        $equiptManager = new \Epi_Model\EquipementManager; 
        $equiptExist = $equiptManager->existEquipt($id);
        if ($equiptExist) 
        {
            $equipementManager = new \Epi_Model\EquipementManager;
            $dataEquipt = $equipementManager->getEquipement($id);
            $equipt = new \Epi_Model\Equipement($dataEquipt);
           
            // Kit
            // $idKit = $equipt->getKitId($id);
            // $kitManager = new \Epi_Model\KitManager;
            // $dataKit = $kitManager->getKit(array($idKit));
            // $kit = new \Epi_Model\Kit($dataKit);

            // Lot
            $idLot = $equipt->getLotId($id);
            $lotManager = new \Epi_Model\LotManager;
            $dataLot = $lotManager->getLot(array($idLot));
            $lot = new \Epi_Model\Kit($dataLot);
            
            // Controles
            $controleManager = new \Epi_Model\ControleManager;
            $dataControles = $controleManager->getControles($id);
            foreach ($dataControles as $data)
            {
                $controle = new \Epi_Model\Controle($data);
                $controles[] = $controle; // Tableau d'objet
            }
            $nxView = new \Epi_Model\View('equipement');
            $nxView->getView(
            array (
                'equipt'=> $equipt,
                //'kit'=> $kit,
                'lot'=> $lot,
                'controles'=>$controles));
        }
        else
        {
           // Nouvelle page 
            $nxView = new \Epi_Model\View();
            $nxView->redirectView('page404');
        }
    }


    public function nxEquipt($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('nxEquipt');
        $token = $csrf->getToken();

        // Liste des activites
        $activiteManager = new \Epi_Model\ActiviteManager;
        $activites = $activiteManager->getActivites();

        // Liste des categories
        $categorieManager = new \Epi_Model\CategorieManager;
        $categories = $categorieManager->getCategories();

        // Liste des kits
        $kitManager = new \Epi_Model\KitManager;
        $kits = $kitManager->getKits();
        
        // Liste des lots
        $lotManager = new \Epi_Model\LotManager;
        $lots = $lotManager->getLots();

        $nxView = new \Epi_Model\View('nxEquipt');
        $nxView->getView(array (
            'activites'=> $activites,
            'categories' => $categories,
            'kits' => $kits,
            'lots' => $lots));
    }

    public function nxControl($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('nxControl');
        $token = $csrf->getToken();

        extract($params); // id equipement
        
        // Vérifier si Equipement existe 
        $equiptManager = new \Epi_Model\EquipementManager; 
        $equiptExist = $equiptManager->existEquipt($id);
        if ($equiptExist) 
        {
            $equipementManager = new \Epi_Model\EquipementManager;
            $dataEquipt = $equipementManager->getEquipement($id);
            $equipt = new \Epi_Model\Equipement($dataEquipt);
            
            $nxView = new \Epi_Model\View('nxControl');
            $nxView->getView(
            array (
                'equipt'=> $equipt));
        }
        else
        {
           // Nouvelle page 
            $nxView = new \Epi_Model\View();
            $nxView->redirectView('page404');
        }
    }

    public function calendrier($params)
    {
        /* Count STATUT */
        $equipementManager = new \Epi_Model\EquipementManager;
        // A réparer        
        $equiptReparation = $equipementManager->countEquiptsStatut('À réparer');
        $_SESSION['countEquiptReparer'] = $equiptReparation;
        // Retard
        $controlRetard = $equipementManager->countControleRetard(); // today
        $_SESSION['countControleRetard'] = $controlRetard; 

        /* Liste Equipements */
        $equipementManager = new \Epi_Model\EquipementManager;
        $dataEquipts = $equipementManager->getEquiptsInvalide($_SESSION['groupeId']);
        foreach ($dataEquipts as $data)
        {
            $equipt = new \Epi_Model\Equipement($data);
            $equipts[] = $equipt; // Tableau d'objet
        }
        $nxView = new \Epi_Model\View('calendrier');
        $nxView->getView(array (
            'equipts'=> $equipts));
    }

    public function historique($params)
    {
        $nxView = new \Epi_Model\View('historique');
        $nxView->getView();
    }

    public function account($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('account');
        $token = $csrf->getToken();

        $UserManager = new \Epi_Model\UserManager; 
        $dataUser = $UserManager->getUser($_SESSION['userId']);

        $user = new \Epi_Model\User($dataUser); // hydratation

        $nxView = new \Epi_Model\View('account');
        $nxView->getView(array (
            'user'=> $user));
    }

    public function deconnexion($params)
    {
        session_unset();
        
        setcookie('userMail');
        setcookie('userPass');

        $_SESSION['message'] = 'Vous êtes déconnecté de votre espace !';

        $nxView = new \Epi_Model\View();
        $nxView->redirectView('home');
    }

    public function upEquipt($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('upEquipt');
        $upEquiptToken = $csrf->getToken();

        extract($params); // id equipement

        // Vérifier si Equipement existe 
        $equiptManager = new \Epi_Model\EquipementManager; 
        $equiptExist = $equiptManager->existEquipt($id);
        if ($equiptExist) 
        {
            $equipementManager = new \Epi_Model\EquipementManager;
            $dataEquipt = $equipementManager->getEquipement($id);

            $equipt = new \Epi_Model\Equipement($dataEquipt);

            // Liste des kits
            $kitManager = new \Epi_Model\KitManager;
            $kits = $kitManager->getKits();
            
            // Liste des lots
            // $lotManager = new \Epi_Model\LotManager;
            // $lots = $lotManager->getLots();

            $nxView = new \Epi_Model\View('upEquipt');
            $nxView->getView(
            array (
                'equipt'=> $equipt,
                'kits' => $kits,
                'lots' => $lots));
        }
        else
        {
           // Nouvelle page 
            $nxView = new \Epi_Model\View();
            $nxView->redirectView('page404');
        }
    }
  
    public function reglementation($params)
    {
        $nxView = new \Epi_Model\View('reglementation');
        $nxView->getView();
    }
  
    public function documentation($params)
    {
        $nxView = new \Epi_Model\View('documentation');
        $nxView->getView();
    }

    /* Link Button ----------------------------*/
    public function inscription($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('inscription');
        $token = $csrf->getToken();

        $nxView = new \Epi_Model\View('inscription');
        $nxView->getView();
    }

    public function nxPass($params)
    {
        $csrf = new \Epi_Model\SecuriteCsrf('nxPass');
        $token = $csrf->getToken();
        
        $nxView = new \Epi_Model\View('nxPass');
        $nxView->getView();
    }

    public function changePass($params)
    {

        $csrf = new \Epi_Model\SecuriteCsrf('changePass');
        $token = $csrf->getToken();
        
        $nxView = new \Epi_Model\View('changePass');
        $nxView->getView();
    }


    /* Erreur 404  ----------------------------*/
    public function page404($params)
    {
        $nxView = new \Epi_Model\View('page404');
        $nxView->getView();
    }
}