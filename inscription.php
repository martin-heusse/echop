<?php 
require_once('def.php');
require_once('Model/Utilisateur.php');

class InscriptionController extends Controller {
    
    
    public function __construct() {
        parent::__construct();
    }

    public function inscription() {
    
        /* Variables d'inscription */
        $s_Login = $_POST['login'];
        $s_passwd = $_POST['motDePasse'];
        $s_email = $_POST['email'];
        $to_checkLogin = Utilisateur::getObjectsByLogin($s_newLogin);
        $i_errLogin = 0;
        $i_errReg = 1;
        
        /* Vérification de la disponibilité du login */
        if ($to_checkLogin != array()) {
            $i_errLogin = 1;
        } else {
            $b_valide = false;
            Utilisateur::create($s_login, $s_passwd, $s_email,$b_valide);
            $i_errReg = 0;
        }
        
      /*  $this->render('inscription',compact('i_errLogin','i_errReg')); 
             header('Location: '.root.'/inscription.php');  */
    }

    public function defaultAction() {
        header('Location: '.root.'/connexion.php/connexion');
    }
}

new InscriptionController();

?>
