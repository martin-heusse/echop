<?php
require_once('def.php');
require_once('Model/Utilisateur.php');

/*
 * Gère les utilisateurs.
 */
class UtilisateurController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche la liste de tous les utilisateurs.
     */
    public function listeUtilisateurValide() {
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
        /* Récupère toutes les infos sur un utilisateur */
        $to_utilisateur = Utilisateur::getObjectsByValidite(true);	
	echo 'coucou';
        $this->render('listeUtilisateurValide', compact('to_utilisateur'));
    }

    /*
     * Affiche la liste de tous les utilisateurs à valider.
     */
    public function listeUtilisateurAValider() {
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
        /* Récupère toutes les infos sur un utilisateur */
        $to_utilisateur = Utilisateur::getObjectsByValidite(0);
	$i_nombreUtilisateurAValider = Utilisateur::getCountByValidite(0);
        $this->render('listeUtilisateurAValider', compact('to_utilisateur'));
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
