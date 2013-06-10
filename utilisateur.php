<?php
require_once('def.php');
require_once('Model/Utilisateur.php');

class UtilisateurController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }


    public function listeUtilisateur() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        // on stocke tous les infos sur un utilisateur
        $to_utilisateur = Utilisateur::getAllObjects();

        $this->render('listeUtilisateur', compact('to_utilisateur'));
    }

    /*
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/utilisateur.php/listeUtilisateur');
    }
}
new UtilisateurController();
?>
