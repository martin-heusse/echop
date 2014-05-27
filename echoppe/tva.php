<?php
require_once('def.php');
require_once('Model/Tva.php');
require_once('Model/Utilisateur.php');

class TvaController extends COntroller {

    /*
     * Constructeur
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche et gère l'ajout de toutes les TVA
     */
    public function gererTva () {
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

        $f_idTva = 0;
        $i_errTVA = 0;
        $i_errFormat = 0;

        if (isset($_POST['id_tva']) && $_POST['id_tva']) {
            $f_idTva = $_POST['id_tva'];

            /* Vérification de la conformité */      
            if ($f_idTva < 0 || $f_idTva > 100) {
                $i_errFormat = 1;
            }


            /* Vérification de la pré-existence */ 
            $o_tva = Tva::getObjectByValeur($f_idTva);

            if ($i_errFormat == 0) { 
                if ($o_tva == array()) {
                    Tva::create($f_idTva);
                } else {
                    $i_errTVA = 1;
                }
            }
            $to_val = Tva::GetAllObjects(); 
            $this->render('gererTva',compact('to_val', 'i_errFormat','i_errTVA'));
            return;
        }


        $to_val = Tva::GetAllObjects(); 
        $this->render('gererTva',compact('to_val', 'i_errTVA','i_errFormat'));
        return;
    }

    /*
     * Action par défaut 
     */
    public function defaultAction() {
        header('Location : '.root.'/tva.php/gererTva');
    }

}
new TvaController();
?>
