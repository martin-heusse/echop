<?php
require_once('def.php');
require_once('Model/Utilisateur.php');

class UtilisateurController extends Controller {

    public function __construct() {
        parent::__construct();
    }


    public function listeUtilisateur() {
        // on stocke tous les infos sur un utilisateur
	$to_utilisateur = Utilisateur::getAllObjects();
	
	$this->render('listeUtilisateur', compact('to_utilisateur'));
    }


    public function defaultAction() {
        header('Location: '.root.'/utilisateur.php/listeUtilisateur');
    }
}
new UtilisateurController();
?>
