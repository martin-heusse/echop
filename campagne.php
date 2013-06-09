<?php
require_once('def.php');
require_once('Model/Campagne.php');
require_once('Model/Commande.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Article.php');
require_once('Model/Unite.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/Rayon.php');
require_once('Model/Fournisseur.php');

/*
 * Gère le modèle Campagne.
 */
class CampagneController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Permet d'ouvrir, de fermer ou de changer de campagne courante.
     */
    public function gererCampagne() {
        $o_campagne = Campagne::getCampagneCourante();
        $this->render('gererCampagne', compact('o_campagne'));
    }

    /*
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/commande.php/mesCampagnes');
    }
}
new CampagneController();
?>
