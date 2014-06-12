<?php

require_once('def.php');
require_once('Model/Utilisateur.php');
require_once('Model/Administrateur.php');
require_once('Util.php');

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
        if (!$_SESSION['isAdministrateur']) {
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
        if (!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }
        /* Récupère toutes les infos sur un utilisateur */
        $to_utilisateur = Utilisateur::getObjectsByValidite(0);
        $i_nombreUtilisateurAValider = Utilisateur::getCountByValidite(0);
        $this->render('listeUtilisateurAValider', compact('to_utilisateur', 'i_nombreUtilisateurAValider'));
    }
    
    /*
     * Affiche la liste de tous les utilisateurs à valider.
     */

    public function listeUtilisateurADesinscrire() {
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
        /* Récupère toutes les infos sur un utilisateur */
        $to_utilisateur = Utilisateur::getObjectsByDesinscrit();
        $i_nombreUtilisateurADesinscrire = Utilisateur::getCountByDesinscrit();
        $this->render('listeUtilisateurADesinscrire', compact('to_utilisateur', 'i_nombreUtilisateurADesinscrire'));
    }

    public function ajouterUtilisateur() {

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
                //Ajout dans la base de donnée
                Utilisateur::create($s_login, $s_passwd, $s_email, $b_valide);
                Utilisateur::createNomPrenom($s_nom, $s_prenom);
                $i_errReg = 0;
                // Validation directement car c'est l'administrateur qui ajoute ici
                $o_utilisateur = Utilisateur::getObjectByLogin($s_login);
                $i_idUtilisateur = $o_utilisateur['id'];
                Utilisateur::setValidite($i_idUtilisateur, 1);
            }
        }
        $this->render('inscription', compact('i_errLogin', 'i_errReg', 's_login', 's_passwd', 's_email'));
    }

    /*
     * Permet de valider l'inscription d'un utilisateur 
     */

    public function validerInscription() {
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
        /* Récupération de l'identifiant de l'utilisateur à ajouter */
        if (isset($_GET['idUtilisateur'])) {
            $i_idUtilisateur = $_GET['idUtilisateur'];
            Utilisateur::setValidite($i_idUtilisateur, 1);
            $s_login = Utilisateur::getLogin($i_idUtilisateur);
            $s_mot_de_passe = Utilisateur::getMotDePasse($i_idUtilisateur);
            $s_destinataire = Utilisateur::getEmail($i_idUtilisateur);
            $s_subject = "[L'Échoppe d'ici et d'ailleurs] Inscription validée";
            $s_message = "Votre inscription a été validée.<br/> Votre login :" . $s_login . "<br/>Votre mot de passe :" . $s_mot_de_passe;
            Util::sendEmail($s_destinataire, $s_subject, $s_message);
        }

        /* $nouveauHeader = "'.root.'/utilisateur.php/listeUtilisateurAValider'";

          echo '<script language="Javascript">
          <!--
          document.location.replace($nouveauHeader);
          // -->
          </script>';
         */
        header('Location: ' . root . '/utilisateur.php/listeUtilisateurAValider');
    }

    /*
     * Permet de valider l'inscription d'un utilisateur 
     */

    public function validerDesinscription() {
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
        /* Récupération de l'identifiant de l'utilisateur à ajouter */
        if (isset($_GET['idUtilisateur'])) {
            $i_idUtilisateur = $_GET['idUtilisateur'];
            $s_nom = Utilisateur::getNom($i_idUtilisateur);
            $s_prenom = Utilisateur::getPrenom($i_idUtilisateur);            
            $s_destinataire = Utilisateur::getEmail($i_idUtilisateur);
            $s_subject = "[L'Échoppe d'ici et d'ailleurs] Désinscription enregistrée";
            $s_message = "$s_nom $s_prenom, votre désinscription a bien été enregistrée .<br/>" ;
            Util::sendEmail($s_destinataire, $s_subject, $s_message);
            Utilisateur::delete($i_idUtilisateur);
        }
        header('Location: ' . root . '/utilisateur.php/listeUtilisateurADesinscrire');
    }

    /*
     * Permet de refuser l'inscription d'un utilisateur 
     */

    public function refuserInscription() {
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
        /* Récupération de l'identifiant de l'utilisateur à supprimer */
        if (isset($_GET['idUtilisateur'])) {
            $i_idUtilisateur = $_GET['idUtilisateur'];
            $s_destinataire = Utilisateur::getEmail($i_idUtilisateur);
            $s_subject = "[L'Échoppe d'ici et d'ailleurs] Inscription refusée";
            $s_message = "Votre inscription a été refusée par un des administrateurs de l'Echoppe d'ici et d'ailleurs.";
            Util::sendEmail($s_destinataire, $s_subject, $s_message);
            Utilisateur::delete($i_idUtilisateur);
        }

        /* $nouveauHeader = "'.root.'/utilisateur.php/listeUtilisateurAValider'";

          echo '<script language="Javascript">
          <!--
          document.location.replace($nouveauHeader);
          // -->
          </script>'; */

        header('Location: ' . root . '/utilisateur.php/listeUtilisateurAValider');
    }

    /*
     * Permet l'envoi de mail à l'ensemble des utilisateurs.
     */

    public function envoiMail() {
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
        /* Pour savoir si le mail a été envoyé */
        $i_emailSent = 0;
        /* Récupération des données du mail et envoi */
        if (isset($_POST['subject']) && $_POST['subject'] != "" && isset($_POST['message']) && $_POST['message'] != "") {
            $i_emailSent = 1;
            /* On récupère les éléments nécésssaires à l'envoi d'un mail */
            $s_subject = "[L'Échoppe d'ici et d'ailleurs] " . htmlentities($_POST['subject'], null, 'UTF-8');
            $s_message = htmlentities($_POST['message'], null, 'UTF-8');
            $to_utilisateur = Utilisateur::getAllObjects();
            /* Pour chaque utilisateur, on envoie un mail */
            foreach ($to_utilisateur as $o_destinataire) {
                if ($o_destinataire['validite'] == 1) {
                    $s_destinataire = $o_destinataire['email'];
                    Util::sendEmail($s_destinataire, $s_subject, $s_message);
                }
            }
        }
        $this->render('envoiMail', compact('i_emailSent'));
    }

    public function envoiMailAAdministrateur() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authentificationRequired');
            return;
        }
        $i_emailSent = 0;
        /* Récupération des données du mail et envoi */
        if (isset($_POST['subject']) && $_POST['subject'] != "" && isset($_POST['message']) && $_POST['message'] != "") {
            $i_emailSent = 1;
            /* On récupère les éléments nécésssaires à l'envoi d'un mail */
            $i_idUtilisateur = $_SESSION['idUtilisateur'];
            $s_email = Utilisateur::getEmail($i_idUtilisateur);
            /* On ajoute l'adresse mail de l'utilisateur dans l'objet */
            $s_subject = "[Mail de : " . $s_email . "] " . htmlentities($_POST['subject'], null, 'UTF-8');
            $s_message = htmlentities($_POST['message'], null, 'UTF-8');
            $to_utilisateur = Utilisateur::getAllObjects();
            /* Pour chaque administrateur, on envoie un mail */
            foreach ($to_utilisateur as $o_destinataire) {
                if (Administrateur::isAdministrateur($o_destinataire['id'])) {
                    $s_destinataire = $o_destinataire['email'];
                    Util::sendEmail($s_destinataire, $s_subject, $s_message);
                }
            }
        }
        $this->render('envoiMailAAdministrateur', compact('i_emailSent'));
    }

    /*
     * Permet de voir et d'éditer son profil 
     */

    public function profil() {

        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authentificationRequired');
            return;
        }
        $i_editProfile = 0;

        /* Récupération des données du profil */
        $s_login = $_SESSION['login'];
        $o_profil = Utilisateur::getObjectByLogin($s_login);
        $i_id = $o_profil['id'];
        $s_password = Utilisateur::getMotDePasse($i_id);
        $s_email = Utilisateur::getEmail($i_id);
        $s_nom = Utilisateur::getNom($i_id);
        $s_prenom = Utilisateur::getPrenom($i_id);

        /* Modification eventuelle du mot de passe  */
        if (isset($_POST['resetMdp']) && $_POST['resetMdp'] != "" && $_POST['resetMdp'] != $s_password) {
            $s_password = $_POST['resetMdp'];
            Utilisateur::setMotDePasse($i_id, $s_password);
            $i_editProfile = 1;
        }

        /* Modification eventuelle de l'email  */
        if (isset($_POST['resetEmail']) && $_POST['resetEmail'] != "" && $_POST['resetEmail'] != $s_email) {
            $s_email = $_POST['resetEmail'];
            Utilisateur::setEmail($i_id, $s_email);
            $i_editProfile = 1;
        }

        /* Modification eventuelle du prenom  */
        if (isset($_POST['resetNom']) && $_POST['resetNom'] != "" && $_POST['resetNom'] != $s_nom) {
            $s_nom = $_POST['resetNom'];
            Utilisateur::setNom($i_id, $s_nom);
            $i_editProfile = 1;
        }

        /* Modification eventuelle du nom */
        if (isset($_POST['resetPrenom']) && $_POST['resetPrenom'] != "" && $_POST['resetPrenom'] != $s_prenom) {
            $s_prenom = $_POST['resetPrenom'];
            Utilisateur::setPrenom($i_id, $s_prenom);
            $i_editProfile = 1;
        }
        $this->render('profil', compact('s_login', 's_password', 's_email', 's_nom', 's_prenom', 'i_editProfile'));
    }

    /*
     * Action par défaut.
     */

    public function defaultAction() {
        header('Location: ' . root . '/utilisateur.php/listeUtilisateur');
    }

}

new UtilisateurController();
?>