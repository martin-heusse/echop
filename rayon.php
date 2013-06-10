<?php
require_once('def.php');
require_once('Model/Rayon.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');

class RayonController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    /* Code Gilou */

    public function gererRayon() {
        $to_rayon = Rayon::getAllObjects();
        $this->render('gererRayon', compact('to_rayon'));
    }

    public function defaultAction() {
        header('Location: '.root.'/connexion.php/connexion');
    }
}
new RayonController();
?>
