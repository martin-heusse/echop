<?php

require_once('def.php');
require_once('Model/Utilisateur.php');
require_once('Util.php');
require_once('Model/Administrateur.php');

class DesinscriptionController extends Controller {
    /*
     * Constructeur
     */

    public function __construct() {
        parent::__construct();
    }

    public function desinscription() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }

        $i_id = $_SESSION['idUtilisateur'];
        Utilisateur::delete($i_id);

        /* Détruit les variables de session */
        session_destroy();
        header('Location: ' . root . '/index.php');
    }

    public function defaultAction() {
        header('Location: ' . root . '/desinscription.php/inscription');
    }

}

new DesinscriptionController();
?>
