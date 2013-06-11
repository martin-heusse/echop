<?php
require_once('def.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');

/*
 * Gère les articles.
 */
class ArticleController extends Controller {

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
        header('Location: '.root.'/accueil.php/accueil');
    }
}
new ArticleController();
?>
