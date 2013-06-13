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
            $s_email = Utilisateur::getEmail($i_idUtilisateur);
            $s_subject = "Inscription validée";
            $s_message = "Votre inscription a été validée. Votre login :". $s_login. "Votre mot de passe :" . $s_mot_de_passe ;
            mail('s_email','s_subject','s_message');
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

        $fake = 0;
        $i_emailSent = 0;

        /* Récupération des données du mail et envoi */
        /*
        if (isset($_POST['subject']) && $_POST['subject'] != "" && isset($_POST['message']) && $_POST['message'] != "") { 
            $s_subject = $_POST['subject'];
            $s_message = $_POST['message']; 
            $to_email = Utilisateur::getAllEmail();
         */

            /*
            $s_message .= "\n";
            $to = 'johann.yvetot@ensimag.fr';
             */
            /* Headers */
          /*  $s_headers = 'MIME-Version : 1.0'."\r\n";
            $s_headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
           */
            /*
            $s_headers = 'From: <johann.yvetot@ensimag.fr>'."\r\n"; 
            $s_headers .= "\r\n";
             */
           /* 
            foreach ($to_email as $o_email) {
                $s_email = $o_email['email'];
                mail('s_email','s_subject','s_message');
            } */
            
            /*
            if (mail('to','s_subject','s_message','s_headers')) {
                $i_emailSent = 1;
                $fake = 2;
            }*/

            $destinataire = "philippe.tran@ensimag.fr";
            //$destinataire = "philippe.tran2@gmail.com";
            $sujet = "salut =)";

            /* Texte */
            $texte = "<p>Salut c'est moi !</p>"."\n\t";

            /* Headers */
            $headers_mail  = 'MIME-Version: 1.0'                           ."\r\n";
            $headers_mail .= 'Content-type: text/html; charset=utf-8'      ."\r\n";
            $headers_mail .= 'From: <philippe.tran@ensimag.fr>'      ."\r\n";
            //$headers_mail .= 'From: <philippe.tran2@gmail.com>'      ."\r\n";
            /* Contenu */
            $message_mail  = "<html>\n\t<head>\n\t</head>\n\t<body>\n\t\t";
            $message_mail .= $texte."\n" ;
            /*
            $message_mail .= "\t\t<h5>Ce message vous a été envoyé
                automatiquement, veuillez ne pas y répondre</h5>\n";
             */
            $message_mail .="\t</body>\n</html>";

            mail($destinataire, $sujet, $message_mail, $headers_mail);
        echo "coucou";
            return;
            /*
        }
        $this->render('envoiMail',compact('i_emailSent','fake'));
             */
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
