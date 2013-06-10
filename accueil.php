<?php
require_once('def.php');
require_once('Model/Utilisateur.php');

/*
 * Gère la page d'accueil.
 */
class AccueilController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche la page d'accueil.
     */
    function accueil() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        $this->render('accueil');
    }

    /*
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/accueil.php/accueil');
    }
}
new AccueilController();
?>
