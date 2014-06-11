<?php

require_once('def.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Rayon.php');
require_once('Model/Tva.php');

require_once('Model/Unite.php');
require_once('Model/Article.php');
require_once('Model/Campagne.php');
require_once('Model/Categorie.php');
require_once('Model/ArticleOrdre.php');

require_once('Model/GererArticle.php');
require_once('Model/ArticleFournisseur.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/Fournisseur.php');
require_once('Model/Categorie.php');

class UpdateBD extends Controller {
    /*
     * Constructeur 
     */

    public function __construct() {
        parent::__construct();
    }

    public function update() {

        /* Insertion des nouvelles données */
        echo "salut \n";
        $to_descriptionArticle = Article::getAllObjects();
        echo "b \n";
        echo count($to_descriptionArticle);
        $commands = "";
        foreach ($to_descriptionArticle as $o_descriptionArticle) {
            echo "a \n";
            $commands = $commands . ' insert into article_ordre(id_article, id_categorie) '
                    . 'values(' . $o_descriptionArticle['id'] . ',' . $o_descriptionArticle['id_categorie'] . ');';
        }


        echo $commands;
    }

    public function defaultAction() {
        header('Location: ' . root . '/rayon.php/afficherRayon');
    }

}

new ArticleController();
?>