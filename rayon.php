<?php
require_once('def.php');
require_once('Model/Rayon.php');
require_once('Model/Article.php');
require_once('Model/Fournisseur.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');

class RayonController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    /* Code Gilou */

    public function gererRayon() {
        $to_rayon = Rayon::getAllObjects();
        $to_fournisseur = Fournisseur::getAllObjects();
        $to_article =  array();
        $i_idRayon = null;
        if( isset($_GET['i_idRayon']) ){
            // reste à vérifier que l'id_rayon est correct sécurité
            $i_idRayon = $_GET['i_idRayon'];
            $to_article = Article::getObjectsByIdRayon($i_idRayon);
        }
        $this->render('gererRayon', compact('to_rayon', 'to_fournisseur', 'i_idRayon', 'to_article'));
    }

    public function defaultAction() {
        header('Location: '.root.'/connexion.php/connexion');
    }
}
new RayonController();
?>
