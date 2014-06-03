<?php 
require_once('def.php');
require_once('Model/Utilisateur.php');
require_once('Util.php');
require_once('Model/Administrateur.php');

class DesinscriptionController extends Controller {

    /*
     * Constructeur
     */
    public function __construct() {
        parent::__construct();
    }

    public function inscription() {
         /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        

                $to_utilisateur = Utilisateur::getAllObjects();
         
                foreach($to_utilisateur as &$o_utilisateur) {
                    $i_idUtilisateur = $o_utilisateur['id'];
                    if(Administrateur::isAdministrateur($i_idUtilisateur)) {
                        $s_destinataire .= Utilisateur::getEmail($i_idUtilisateur).",";       
                    } 
                } 
                $s_subject = "Inscription en cours";
                $s_message = "Un utilisateur vient de s'inscrire. Vous pouvez valider ou refuser l'inscription en allant sur le site." ;
                Util::sendEmail($s_destinataire, $s_subject, $s_message);
            
        
        $this->render('inscription',compact('i_errLogin','i_errReg',
            's_login','s_passwd','s_email'));
    }

   
    public function defaultAction() {
        header('Location: '.root.'/inscription.php/inscription');
    }
}
new InscriptionController();
?>
