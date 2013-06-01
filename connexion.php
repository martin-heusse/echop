<?php
require_once('def.php');
require_once('Model/Admin.php');

class connexionController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    function connexion() {
        /* L'utilisateur doit être déconnecté */
        if (Admin::isLogged()) {
            header('Location: '.root.'/article.php');
        }
        /* Connexion */
        if (isset($_POST['login']) && $_POST['login'] != ""
            && isset($_POST['password']) && $_POST['password'] != "") {
            $login    = $_POST['login'];
            $password = $_POST['password'];
            /* Authentification réussie */
            if ($id = Admin::authentication($login, $password)) {
                /* Initialisation des variables de session */
                $_SESSION['login'] = Admin::getLogin($id);
                $_SESSION['nom']   = Admin::getNom($id);
                /* Redirection vers l'index */
                header('Location: '.root.'/article.php');
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
        if (!Admin::isLogged()) {
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
new connexionController();
?>
