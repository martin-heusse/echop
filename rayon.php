<?php
require_once('def.php');
require_once('Model/Tva.php');
require_once('Model/Rayon.php');
require_once('Model/Unite.php');
require_once('Model/Article.php');
require_once('Model/Campagne.php');
require_once('Model/ArticleFournisseur.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/Fournisseur.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');

class RayonController extends Controller {

    public function __construct() {
        parent::__construct();
    }


    public function afficherRayon() {
        // liste des rayons (à partir de la table rayon)
        // pour afficher la liste rayons
        $to_rayon = Rayon::getAllObjects();
        $this->render('gererRayon', compact('to_rayon'));
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
                $this->render('gererRayon', compact('to_rayon'));       
            }
        }

       $this->render('creerRayon',compact('i_rayonSet','i_errName'));
    }

    
    public function defaultAction() {
        header('Location: '.root.'/rayon.php/creerRayon');
    }
}
new RayonController();
?>
