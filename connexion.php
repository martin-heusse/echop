<?php
require_once('def.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');

class ConnexionController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    function connexion() {
        /* L'utilisateur doit être déconnecté */
        if (Utilisateur::isLogged()) {
            header('Location: '.root.'/index.php');
        }
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
                $_SESSION['email']            = Utilisateur::getEmail($i_id);
                $_SESSION['isAdministrateur'] = Administrateur::isAdministrateur($i_id);
                /* Redirection vers la page d'index */
                header('Location: '.root.'/index.php');
            }
            /* Échec lors de l'authentification */
            else {
                // TODO message d'erreur
                $this->render('connexion');
            }
        }
        /* Afficher la page de connexion */
        else {
            $this->render('connexion');
        }
    }

    public function deconnexion() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        session_destroy();
        header('Location: '.root.'/index.php');

    }

    public function defaultAction() {
        header('Location: '.root.'/connexion.php/connexion');
    }
}
new ConnexionController();
?>
