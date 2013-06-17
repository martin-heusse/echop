<?php
require_once('def.php');
require_once('Model/Rayon.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Categorie.php');

class RayonController extends Controller {

    public function __construct() {
        parent::__construct();
    }


    public function afficherRayon() {
        // liste des rayons (à partir de la table rayon)
        // pour afficher la liste rayons
        $to_categorie = Categorie::getAllObjects();
        $to_rayon = Rayon::getAllObjects();
        $this->render('gererRayon', compact('to_rayon','to_categorie'));
    }

    public function creerRayon() {
        $i_rayonSet = 0;
        $i_errName = 0;
        if (!Utilisateur::isLogged()) {
            header('Location: '.root.'/authentificationRequired');
        }

        if (isset($_POST['nomRayon']) && $_POST['nomRayon'] != "") {
            $s_nomRayon = $_POST['nomRayon'];

            /* Vérification de la disponibilité du nom */
            $o_nom = Rayon::getObjectByNom($s_nomRayon);

            if ($o_nom != array()) {
                $i_errName = 1;
            } else {

                $i_rayonSet = 1;
                Rayon::create($s_nomRayon);
                $to_rayon = Rayon::getAllObjects();
        $to_rayon = Rayon::getAllObjects();
        $this->render('gererRayon', compact('to_rayon','to_categorie'));
            }
        }

        $this->render('creerRayon',compact('i_rayonSet','i_errName'));
    }

    public function modifierRayon() {
        $i_errNewName = 0;
        $i_oldRayonSet = 0;
        $to_rayon = Rayon::getAllObjects();
        $i_idRayon = 0;
        if (!Utilisateur::isLogged()) {
            header('Location: '.root.'/authentificationRequired');
        }


        if (isset($_GET['idRayon']) && $_GET['idRayon'] != "") {
            $i_oldRayonSet = 1;
            $i_idRayon = $_GET['idRayon'];
            $s_Rayon = Rayon::getNom($i_idRayon); 
            $f_marge = 100*Rayon::getMarge($i_idRayon);
            $this->render('modifierRayon',compact('f_marge','s_Rayon','i_idRayon','i_errNewName','i_oldRayonSet','to_rayon'));
        }

        if (isset($_POST['newNomRayon']) && $_POST['newNomRayon'] != "") {
            $s_nomRayon = $_POST['newNomRayon'];
            $i_id = $_POST['idRayon'];

            /* Vérification de la disponibilité du nom */ 
            $o_nom = Rayon::getObjectByNom($s_nomRayon);

            if ($o_nom != array()) {
                $i_errNewName = 1;
                $i_oldRayonSet = 1;
            } else {
                Rayon::setNom($i_id,$s_nomRayon);
                $to_rayon = Rayon::getAllObjects();
        $to_rayon = Rayon::getAllObjects();
        $this->render('gererRayon', compact('to_rayon','to_categorie'));
            }

        }

        $this->render('modifierRayon',compact('i_errNewName','i_oldRayonSet','to_rayon', 's_nomRayon'));
    }

    public function defaultAction() {
        header('Location: '.root.'/rayon.php/creerRayon');
    }
}
new RayonController();
?>
