<?php 
require_once('def.php');
require_once('Model/Utilisateur.php');

class InscriptionController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function inscription() {
        if (Utilisateur::isLogged()) {    
            return;
        }
        /* Variables d'inscription */
        $i_errReg = 1;
        $i_errLogin = 0;
        $s_login = "undo";
        $s_passwd = "undo";
        $s_email = "undo";
        if (isset($_POST['login']) && isset($_POST['motDePasse']) && isset($_POST['email']) && $_POST['login'] != "" && $_POST['motDePasse'] != "" && $_POST['email'] != "") {
            $s_login = $_POST['login'];
            $s_passwd = $_POST['motDePasse'];
            $s_email = $_POST['email'];
            
            $to_checkLogin = Utilisateur::getObjectsByLogin($s_login);
            
            /* Vérification de la disponibilité du login */
            if ($to_checkLogin != array()) {
                $i_errLogin = 1; 
            } else {
                $b_valide = 0;
                Utilisateur::create($s_login, $s_passwd, $s_email,$b_valide);
                $i_errReg = 0;
                /* Envoie du mail pour avertir les administrateurs */
                // récupérer les mails des admins
                // foreach :
                //UtilisateurController::sendEmail($s_destinataire, $s_subject, $s_message);
            }
        } 
        $this->render('inscription',compact('i_errLogin','i_errReg',
            's_login','s_passwd','s_email'));
    }

    /*
     * Affiche la page d'oublie de mot de passe.
     */
    public function passOubliE() {
        if(!isset($_POST['login'])) {
            $this->render('passOubliE');
            return;
        }
        $s_login = htmlentities($_POST['login']);
        $o_utilisateur = Utilisateur::getObjectByLogin($s_login);
        $s_destinataire = $o_utilisateur['email'];
        $s_motDePasse = $o_utilisateur['mot_de_passe'];
        $s_subject = "[L'Échoppe d'ici et d'ailleurs] Oubli de mot de passe";
        $s_message = "Votre login : ".$s_login."\nVotre mot de passe : ".$s_motDePasse;
        UtilisateurController::sendEmail($s_destinataire, $s_subject, $s_message);
    }

    public function defaultAction() {
        header('Location: '.root.'/inscription.php/inscription');
    }
}
new InscriptionController();
?>
