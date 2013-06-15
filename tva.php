<?php
require_once('def.php');
require_once('Model/Tva.php');

class TvaController extends COntroller {

    /*
     * Constructeur
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche toutes les TVA
     */
    public function gererTva () {

        $f_idTva = 0;
        $i_errTVA = 0;
        if (isset($_POST['id_tva']) && $_POST['id_tva']) {
            $f_idTva = $_POST['id_tva'];
            /* TODO valeur à accepter */      
            /* Vérification de la pré-existence */ 
            $o_tva = Tva::getObjectByValeur($f_idTva);
            if ($o_tva == array()) {
                Tva::create($f_idTva);
            } else {
                $i_errTVA = 1;
            }
            $to_val = Tva::GetAllObjects(); 
            $this->render('gererTva',compact('to_val', 'i_errTVA'));
            return;
        }


        $to_val = Tva::GetAllObjects(); 
        $this->render('gererTva',compact('to_val', 'i_errTVA'));
        return;
    }

    public function defaultAction() {
        header('Location : '.root.'/tva.php/gererTva');
    }

}
new TvaController();
?>
