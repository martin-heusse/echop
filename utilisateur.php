<?php
require_once('def.php');
require_once('Model/Utilisateur.php');

/*
 * Gère les utilisateurs.
 */
class UtilisateurController extends Controller {

    /* 
     * Fonction pour envoyer un mail.
     */
    public static function sendEmail($s_destinataire, $s_subject, $s_message) {
        /* Header */
        $s_header  = 'MIME-Version: 1.0'."\r\n";
        $s_header .= 'Content-type: text/html; charset=utf-8'."\r\n";
        $s_header .= 'From: <philippe.tran@ensimag.fr>'."\r\n"; // a changer
        /* Contenu */
        $s_contenu  = "<html>\n\t<head>\n\t</head>\n\t<body>\n\t\t";
        $s_contenu .= "<p>".$s_message."</p>\n" ;
        $s_contenu .= "\t</body>\n</html>";
        // Envoie du mail
        mail($s_destinataire, $s_subject, $s_contenu, $s_header);
    }

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
        $this->render('listeUtilisateurAValider', compact('to_utilisateur','i_nombreUtilisateurAValider'));
    }

    /* Permet de valider l'inscription d'un utilisateur */

    public function validerInscription (){
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
        /* Récupération de l'identifiant de l'utilisateur à ajouter */
        if (isset($_GET['idUtilisateur'])) {
            $i_idUtilisateur = $_GET['idUtilisateur'];
            Utilisateur::setValidite($i_idUtilisateur, 1);
            $s_login = Utilisateur::getLogin($i_idUtilisateur);
            $s_mot_de_passe = Utilisateur::getMotDePasse($i_idUtilisateur);
            $s_destinataire = Utilisateur::getEmail($i_idUtilisateur);
            $s_subject = "Inscription validée";
            $s_message = "Votre inscription a été validée. Votre login :". $s_login. "Votre mot de passe :" . $s_mot_de_passe ;
            UtilisateurController::sendEmail($s_destinataire, $s_subject, $s_message);
        }
        header('Location: '.root.'/utilisateur.php/listeUtilisateurAValider');
    }


    /* Permet de refuser l'inscription d'un utilisateur */

    public function refuserInscription (){
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
        /* Récupération de l'identifiant de l'utilisateur à supprimer */
        if (isset($_GET['idUtilisateur'])) {
            $i_idUtilisateur = $_GET['idUtilisateur'];
            Utilisateur::delete($i_idUtilisateur);   
        }
        header('Location: '.root.'/utilisateur.php/listeUtilisateurAValider');
    }

    /*
     * Permet l'envoi de mail à l'ensemble des utilisateurs.
     */
    public function envoiMail() {
        /* Authentification required */
        if (!Utilisateur::isLogged()) {
            $this->render('authentificationRequired');
            return;
        }
        $i_emailSent = 0;
        /* Récupération des données du mail et envoi */
        if (isset($_POST['subject']) && $_POST['subject'] != "" && isset($_POST['message']) && $_POST['message'] != "") { 
            $i_emailSent = 1;
            $s_subject = htmlentities($_POST['subject']);
            $s_message = htmlentities($_POST['message']); 
            $ts_email = Utilisateur::getAllEmail();
            foreach ($ts_email as $s_destinataire) {
                UtilisateurController::sendEmail($s_destinataire, $s_subject, $s_message);
            }
        }
        $this->render('envoiMail' ,compact('i_emailSent'));
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
