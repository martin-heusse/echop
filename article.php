<?php
require_once('def.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');

class ArticleController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    function commanderArticle() {
        $this->render('commanderArticle');
    }

    public function defaultAction() {
        header('Location: '.root.'/connexion.php/connexion');
    }
}
new ArticleController();
?>
