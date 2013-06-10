<?php 
require_once('def.php');
require_once('Model/Utilisateur.php');

class InscriptionController extends Controller {
    
    
    public function __construct() {
        parent::__construct();
    }

    public function inscription() {
    
        /* Variable de vérification */
        $s_newLogin = $_POST['login'];
        $to_checkLogin = Utilisateur::getObjectsByLogin($s_newLogin);
        $i_errLogin = 0;
        $i_errReg = 1;
        
        /* Vérification de la disponibilité du login */
        if ($to_checkLogin != array()) {
            $i_errLogin = 1;
        } else {
            $i_errReg = 0;
        }
        
        $this->render('inscription',compact('i_errLogin','i_errReg')); 
        header('Location: '.root.'/inscription.php');
    }
}

new InscriptionController();

?>
