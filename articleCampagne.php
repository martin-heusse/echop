<?php
require_once('def.php');

/*
 * Gère le modèle ArticleCampagne.
 */
class ArticleCampagneController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /* 
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/articleCampagne.php/fournisseursChoisis');
    }
}
new ArticleCampagneController();
?>
