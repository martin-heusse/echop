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
 * Gère les campagnes.
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
        /* Ouvrir ou fermer la campagne courante */
        if (isset($_GET['etat'])) {
            $b_etat = $_GET['etat'];
            $i_idCampagneCourante = Campagne::getIdCampagneCourante();
            if ($b_etat == 1) {
                Campagne::setEtat($i_idCampagneCourante, 1);
            } else if ($b_etat == 0) {
                Campagne::setEtat($i_idCampagneCourante, 0);
            }
        }
        /* Affiche la page de gestion de la campagne courante */
        $o_campagne = Campagne::getCampagneCourante();
        $this->render('gererCampagne', compact('o_campagne'));
    }

    /*
     * Archive la campagne courante et en ouvre une nouvelle.
     */
    public function nouvelleCampagne() {
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
        $i_idCampagneCourante = Campagne::getIdCampagneCourante();
        $b_etat = Campagne::getEtat($i_idCampagneCourante);
        /* La campagne courante doit être fermée */
        if ($b_etat == 1) {
            header('Location: '.root.'/campagne.php/gererCampagne');
            return;
        }
        /* Désafecte la campagne courante */
        Campagne::setCourant($i_idCampagneCourante, 0);
        /* Crée la nouvelle campagne */
        $s_dateDebut = "2013-06-12";
        $b_etat = 1;
        $b_courant = 1;
        $i_idCampagneCourante = Campagne::create($s_dateDebut, $b_etat, $b_courant);
        header('Location: '.root.'/campagne.php/gererCampagne');
    }

    /*
     * Affiche l'historique des campagnes passées.
     */
    public function historiqueCampagne() {
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
        $to_campagne = Campagne::getObjectsByCourant(0);
        $this->render('historiqueCampagne', compact('to_campagne'));
    }

    /*
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/campagne.php/gererCampagne');
    }
}
new CampagneController();
?>
