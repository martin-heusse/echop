<?php
require_once('def.php');
require_once('Model/Commande.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');

class CommandeController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    /* Code Aurore */

    public function mesCommandes() {

    }

    /* */

    /* Code Johann */

    public function commanderArticle() {

    }

    /* */

    public function defaultAction() {
        header('Location: '.root.'/connexion.php/connexion');
    }
}
new CommandeController();
?>
