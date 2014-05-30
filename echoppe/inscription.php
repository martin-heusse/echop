<?php 
require_once('def.php');
require_once('Model/Utilisateur.php');
require_once('Util.php');
require_once('Model/Administrateur.php');

class InscriptionController extends Controller {

    /*
     * Constructeur
     */
    public function __construct() {
        parent::__construct();
    }

    public function inscription() {
        /* L'utilisateur doit être déconnecté */
        if (Utilisateur::isLogged()) {
            header('Location: '.root.'/index.php');
            return;
        }
        /* Variables d'inscription */
        $i_errReg = 1;
        $i_errLogin = 0;
        $s_login = "undo";
        $s_passwd = "undo";
        $s_email = "undo";
        $s_nom = "undo";
        $s_prenom = "undo";
        if (isset($_POST['login']) && isset($_POST['motDePasse']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && $_POST['login'] != "" && $_POST['motDePasse'] != "" && $_POST['email'] != "" && $_POST['nom'] != "" && $_POST['prenom'] != "") {
            $s_nom = $_POST['nom'];
            $s_prenom = $_POST['prenom'];
            $s_login = $_POST['login'];
            $s_passwd = $_POST['motDePasse'];
            $s_email = $_POST['email'];

            $to_checkLogin = Utilisateur::getObjectsByLogin($s_login);

            /* Vérification de la disponibilité du login */
            if ($to_checkLogin != array()) {
                $i_errLogin = 1; 
            } else {
                $b_valide = 0;
                Utilisateur::create($s_nom, $s_prenom ,$s_login, $s_passwd, $s_email,$b_valide);
                $i_errReg = 0;
                /* Envoie du mail pour avertir les administrateurs */
                // récupérer les mails des admins
                $to_utilisateur = Utilisateur::getAllObjects();
                $s_destinataire="";
                foreach($to_utilisateur as &$o_utilisateur) {
                    $i_idUtilisateur = $o_utilisateur['id'];
                    if(Administrateur::isAdministrateur($i_idUtilisateur)) {
                        $s_destinataire .= Utilisateur::getEmail($i_idUtilisateur).",";       
                    } 
                } 
                $s_subject = "Inscription en cours";
                $s_message = "Un utilisateur vient de s'inscrire. Vous pouvez valider ou refuser l'inscription en allant sur le site." ;
                Util::sendEmail($s_destinataire, $s_subject, $s_message);
            }
        } 
        $this->render('inscription',compact('i_errLogin','i_errReg',
            's_login','s_passwd','s_email'));
    }

    /*
     * Affiche la page d'oublie de mot de passe.
     */
    public function passOubliE() {
        /* L'utilisateur doit être déconnecté */
        if (Utilisateur::isLogged()) {
            header('Location: '.root.'/index.php');
            return;
        }
        $b_erreurLogin = 0;
        $b_success = 0;
        if(!isset($_POST['login'])) {
            $this->render('passOubliE', compact('b_erreurLogin', 'b_success'));
            return;
        }
        $s_login = htmlentities($_POST['login'], null,'UTF-8');
        $o_utilisateur = Utilisateur::getObjectByLogin($s_login);
        /* Le login n'existe pas */
        if ($o_utilisateur == array() or $o_utilisateur == null) {
            $b_erreurLogin = 1;
            $this->render('passOubliE', compact('b_erreurLogin', 'b_success'));
            return;
        }
        $s_login = Utilisateur::getLogin($o_utilisateur['id']);
        $s_destinataire = $o_utilisateur['email'];
        $s_motDePasse = $o_utilisateur['mot_de_passe'];
        $s_subject = "[L'Échoppe d'ici et d'ailleurs] Oubli de mot de passe";
        $s_message = "Votre login : ".$s_login."<br/>Votre mot de passe : ".$s_motDePasse;
        Util::sendEmail($s_destinataire, $s_subject, $s_message);
        $b_success = 1;
        $this->render('passOubliE', compact('s_destinataire', 'b_erreurLogin', 'b_success'));
    }

    public function defaultAction() {
        header('Location: '.root.'/inscription.php/inscription');
    }
}
new InscriptionController();
?>
