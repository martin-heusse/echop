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
        $to_rayon = Rayon::getAllObjects();
        $to_categorie = Categorie::getAllObjects();
        $this->render('gererRayon', compact('to_rayon','to_categorie'));
    }

    public function creerRayon() {
        $i_rayonSet = 0;
        $i_errName = 0;
        $i_errMarge = 0;
        if (!Utilisateur::isLogged()) {
            header('Location: '.root.'/authentificationRequired');
        }

        if (isset($_POST['nomRayon']) && $_POST['nomRayon'] != "" && isset($_POST['marge'])) {
            $f_marge = $_POST['marge'];
            $s_nomRayon = $_POST['nomRayon'];

            $o_nom = Rayon::getObjectByNom($s_nomRayon);
            if($o_nom != array() || $f_marge > 100 || $f_marge < 0 ) {
                /* Vérification que la marge est compris entre 0 et 1 */
                if ($_POST['marge']<0 || $_POST['marge']>100) {
                    $i_errMarge = 1;
                }
            /* Vérification de la disponibilité du nom */
                if ($o_nom != array()) {
                    $i_errName = 1;
                }
            } else {
                $i_rayonSet = 1;
                $f_marge=$f_marge/100;
                Rayon::create($s_nomRayon, $f_marge);
                $to_rayon = Rayon::getAllObjects();
                $to_categorie = Categorie::getAllObjects();
                $this->render('gererRayon', compact('to_rayon','to_categorie'));
            }
        }
        $this->render('creerRayon',compact('i_rayonSet','i_errName', 'i_errMarge'));
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
            $f_marge = 100 * Rayon::getMarge($i_idRayon);
            $this->render('modifierRayon',compact('f_marge','s_Rayon','i_idRayon','i_oldRayonSet','i_errNewName','to_rayon'));
            return;
        }

        if (isset($_POST['newNomRayon']) && $_POST['newNomRayon'] != "") {
            $s_nomRayon = $_POST['newNomRayon'];
            $i_id = $_POST['idRayon'];
            $f_marge = 100 * Rayon::getMarge($i_id);

            /* Vérification de la disponibilité du nom */ 
            $o_nom = Rayon::getObjectByNom($s_nomRayon);

            if ($o_nom != array()) {
                $i_errNewName = 1;
                $i_oldRayonSet = 1;
                $s_Rayon = Rayon::getNom($i_id);
                $this->render('modifierRayon',compact('f_marge','i_errNewName','i_oldRayonSet','s_Rayon'));
                return;
            } else {
                Rayon::setNom($i_id,$s_nomRayon);
                $to_rayon = Rayon::getAllObjects();
                $to_categorie = Categorie::getAllObjects();
                $this->render('gererRayon', compact('to_rayon','to_categorie'));
                return;
            }

        }

        if (isset($_POST['marge']) && $_POST['marge'] != "") {
            $f_marge = (float)($_POST['marge']/100);
            $i_id = $_POST['idRayon'];
            Rayon::setMarge($i_id,$f_marge);
            $to_rayon = Rayon::getAllObjects();
            $this->render('gererRayon', compact('to_rayon'));
            return;
        }

        $this->render('modifierRayon',compact('to_rayon','i_oldRayonSet','i_errNewName'));
        return;
    }

    public function defaultAction() {
        header('Location: '.root.'/rayon.php/creerRayon');
    }
}
new RayonController();
?>
