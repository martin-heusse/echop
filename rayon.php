<?php
require_once('def.php');
require_once('Model/Tva.php');
require_once('Model/Rayon.php');
require_once('Model/Unite.php');
require_once('Model/Article.php');
require_once('Model/Campagne.php');
require_once('Model/ArticleFournisseur.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/Fournisseur.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');

class RayonController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    /* Code Gilou */

    public function gererRayon() {
        // liste des rayons (à partir de la table rayon)
        // pour afficher la liste rayons
        $to_rayon = Rayon::getAllObjects();
        // liste de tous les fournisseurs
        $to_fournisseur = Fournisseur::getAllObjects();
        // liste des descriptions des articles (à partir des tables  :
        // article, article_fournisseur et article_campagne)
        $to_descriptionArticle = array();
        $i_idRayon = null;
        $ts_nomFourniseur = array();
        if( isset($_GET['i_idRayon']) ){
            // reste à vérifier que l'id_rayon est correct sécurité
            $i_idRayon = $_GET['i_idRayon'];
            $i_idCampagneEnCours = Campagne::getIdCampagneCourante();
            $to_descriptionArticle = ArticleCampagne::getObjectsByIdCampagne($i_idCampagneEnCours);
            foreach($to_descriptionArticle as &$o_descriptionArticle){
                $i_idArticle = $o_descriptionArticle['id_article'];
                $i_idArticleCampagne = $o_descriptionArticle['id'];
                $o_article = Article::getObject($i_idArticle);
                //if($o_article['id_rayon'] != $i_idRayon){
                    //unset($o_descriptionArticle);
                //} else {
                    $i_idUnite = $o_article['id_unite'];
                    $o_descriptionArticle['unite'] = Unite::getUnite($i_idUnite);
                    $o_descriptionArticle['nom'] = $o_article['nom'];
                    $o_descriptionArticle['poids_paquet_fournisseur'] = $o_article['poids_paquet_fournisseur'];
                    $o_descriptionArticle['nb_paquet_colis'] = $o_article['nb_paquet_colis'];
                    $o_descriptionArticle['description_longue'] = $o_article['description_longue'];
                    $o_descriptionArticle['description_courte'] = $o_article['description_courte'];
                    // retourne le nom de tous les fournisseurs
                    // obtenir le prix et le code de chaque fournisseur
                    $to_articleFournisseur = ArticleFournisseur::getObjectsByIdArticle($i_idArticle);
                    foreach($to_articleFournisseur as &$o_articleFournisseur){
                        $i_idArticleFournisseur = $o_articleFournisseur['id'];
                        $i_idFournisseur = $o_articleFournisseur['id_fournisseur'];
                        $s_nomFourniseur = Fournisseur::getNom($i_idFournisseur);
                        $o_descriptionArticle[$s_nomFourniseur]['code'] = ArticleFournisseur::getCode($i_idArticleFournisseur );
                        $o_descriptionArticle[$s_nomFourniseur]['prix_article'] = ArticleFournisseur::getPrixArticle($i_idArticleFournisseur);
                        var_dump($o_descriptionArticle[$s_nomFourniseur]['prix_article']);
                        return;
                    }
                    // on considère que le montant tva dépend de l'article
                    $i_idTva = ArticleCampagne::getIdTva($i_idArticleCampagne);
                    $o_descriptionArticle['tva'] = Tva::getValeur($i_idTva);
                //}
            }
        }
        $this->render('gererRayon', compact('to_rayon', 'to_fournisseur', 'i_idRayon', 'to_descriptionArticle'));
    }

    public function defaultAction() {
        header('Location: '.root.'/connexion.php/connexion');
    }
}
new RayonController();
?>
