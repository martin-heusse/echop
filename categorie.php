<?php
require_once('def.php');
require_once('Model/Categorie.php');
require_once('Model/Utilisateur.php');
require_once('Model/Rayon.php');

class CategorieController extends Controller {

    /*
     * Constructeur
     */
    public function __construct() {
        parent::__construct();
    }


    /*
     * Crée une catégorie d'articles
     */
    public function creerCategorie() {

        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }

        /* Doit être un administrateur */
        if(!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }

        $i_categorieSet = 0;
        $i_errName = 0;
        /* Gestion des requetes */
        if (isset($_POST['nomCategorie']) && $_POST['nomCategorie'] != "") {
            $s_nomCategorie = $_POST['nomCategorie'];

            /* Vérification de la disponibilité du nom */
            $o_nom = Categorie::getObjectByNom($s_nomCategorie);
            
            if($o_nom != array()) {
                $i_errName = 1;
            } else {
                $i_categorieSet = 1;
                Categorie::create($s_nomCategorie);
            
                $to_rayon = Rayon::getAllObjects();
                $to_categorie = Categorie::getAllObjects();
                $this->render('gererRayon', compact('to_rayon','to_categorie'));
            }
        }
        $this->render('creerCategorie',compact('i_categorieSet','i_errName'));
    }

    /*
     * Modifie le om d'une catégorie existente 
     */
    public function modifierCategorie() {

        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }

        /* Doit être un administrateur */
        if(!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }

        $i_errNewName = 0;
        $i_oldCategorieSet = 0;
        $to_categorie = Categorie::getAllObjects();
        $i_idCategorie = 0;
        /* Gestion du choix de la catégorie */
        if (isset($_GET['idCategorie']) && $_GET['idCategorie'] != "") {
            $i_oldCategorieSet = 1;
            $i_idCategorie = $_GET['idCategorie'];
            $s_Categorie = Categorie::getNom($i_idCategorie); 
            $this->render('modifierCategorie',compact('s_Categorie','i_idCategorie','i_oldCategorieSet','i_errNewName','to_categorie'));
            return;
        }

        /* Gestion de la requête de remplacement du nom */
        if (isset($_POST['newNomCategorie']) && $_POST['newNomCategorie'] != "") {
            $s_nomCategorie = $_POST['newNomCategorie'];
            $i_id = $_POST['idCategorie'];

            $o_nom = Categorie::getObjectByNom($s_nomCategorie);

            /* Vérification de la disponibilité du nom */ 
            if ($o_nom != array()) {
                $i_errNewName = 1;
                $i_oldCategorieSet = 1;
                $s_Categorie = Categorie::getNom($i_id);
                $this->render('modifierCategorie',compact('i_errNewName','i_oldCategorieSet','s_Categorie'));
                return;
            } else {
                Categorie::setNom($i_id,$s_nomCategorie);
                $to_categorie = Categorie::getAllObjects();
                $to_rayon = Rayon::getAllObjects();
                $this->render('gererRayon', compact('to_rayon','to_categorie'));
                return;
            }

        }

        $this->render('modifierCategorie',compact('to_categorie','i_oldCategorieSet','i_errNewName'));
        return;
    }

    public function defaultAction() {
        header('Location: '.root.'/categorie.php/creerCategorie');
    }
}
new CategorieController();
?>
