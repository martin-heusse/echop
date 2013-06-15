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

        if (isset($_POST['id_tva']) && $_POST['id_tva']) {
            $f_idTva = $_POST['id_tva'];
       
            /* Vérification de la pré-existence */ 
            $o_tva = Tva::getObjectByValeur($f_idTva);

            if ($o_tva == array()) {
                Tva::create($f_idTva);
            }

            $to_val = Tva::GetAllObjects(); 
            $this->render('gererTva',compact('to_val'));
            return;
        }


        $to_val = Tva::GetAllObjects(); 
        $this->render('gererTva',compact('to_val'));
        return;
    }

    public function defaultAction() {
        header('Location : '.root.'/tva.php/gererTva');
    }

}
new TvaController();
?>
