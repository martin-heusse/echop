<?php
require_once('def.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Fournisseur.php');

class FournisseurController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function tousLesFournisseurs() {
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
        $to_fournisseur = Fournisseur::getAllObjects();
        $this->render('tousLesFournisseurs', compact('to_fournisseur'));
    }

    public function defaultAction() {
        header('Location: '.root.'/fournisseur.php/tousLesFournisseurs');
    }
}
new FournisseurController();
?>
