<?php
require_once('def.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');

/*
 * Gère la connexion.
 */
class ConnexionController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche la page de connexion.
     */
    public function connexion() {
        /* L'utilisateur doit être déconnecté */
        if (Utilisateur::isLogged()) {
            header('Location: '.root.'/index.php');
            return;
        }
        /* L'utilisateur doit être inscrit et validé */
        
        $i_errConnexion = 0;
        /* Connexion */
        if (isset($_POST['login']) && $_POST['login'] != ""
            && isset($_POST['motDePasse']) && $_POST['motDePasse'] != "") {
            $s_login      = $_POST['login'];
            $s_motDePasse = $_POST['motDePasse'];
            /* Authentification réussie */
            if ($i_id = Utilisateur::authentication($s_login, $s_motDePasse)) {
                /* Initialisation des variables de session */
                $_SESSION['idUtilisateur']   = $i_id;
                $_SESSION['login']            = Utilisateur::getLogin($i_id);
                $_SESSION['isAdministrateur'] = Administrateur::isAdministrateur($i_id);
                /* Redirection vers les pages associées */
                header('Location: '.root.'/accueil.php/accueil');
            }
            /* Échec lors de l'authentification */
            else {
                $i_errConnexion = 1; 
                $this->render('connexion', compact('i_errConnexion'));
            }
        }
        /* Afficher la page de connexion */
        else {
            $this->render('connexion', compact('i_errConnexion'));
        }
    }

    /*
     * Se déconnecter.
     */
    public function deconnexion() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Détruit les variables de session */
        session_destroy();
        header('Location: '.root.'/index.php');
    }

    /*
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/connexion.php/connexion');
    }
}
new ConnexionController();
?>
