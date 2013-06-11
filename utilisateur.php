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
        $fake = 0;
        $to='johann.yvetot@ensimag.fr';
        $sub = 'test';
        $mesg = 'merde';
        mail($to,$sub,$mesg);


        /* Récupère les données du mail à envoyer */
        if (isset($_POST['message']) && $_POST['subject'] != "" && isset($_POST['message']) && $_POST['message'] != "") { 
             
            $s_subject = $_POST['subject'];
            $s_message = $_POST['message']; 
            $to_email = Utilisateur::getAllEmail();
            $fake = 1;
            

            foreach ($to_email as $o_email) {
                $s_email = $o_email['email'];
                mail('s_email','s_subject','s_message');
            }
            $i_emailSent = 1;
        }
        $this->render('envoiMail',compact('i_emailSent','fake'));
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
