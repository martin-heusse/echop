<?php

require_once('def.php');
require_once('Model/Utilisateur.php');
require_once('Util.php');

/*
 * Gère les exportations de données.
 */

class ExportController extends Controller {
    /*
     * Constructeur.
     */

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * Affiche la liste des exportations ou importations BD proposées
     */
    public function listeExport() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        if (!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }
        /* Récupère toutes les infos sur les bases de données*/
        $to_utilisateur = Utilisateur::getObjectsByValidite(true);       
        $this->render('listeExport','' /*Mettre la liste des param requis à la view*/);
    }
    
    
    public function defaultAction() {
        header('Location: ' . root . '/utilisateur.php/listeUtilisateur');
        /*A changer*/
    }

}
new ExportController();
?>
