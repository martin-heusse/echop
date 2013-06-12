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


// Gère les articles.
class ArticleController extends Controller {


    // Constructeur.
    public function __construct() {
        parent::__construct();
    }

    public function afficherArticle() {
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
                    $o_descriptionArticle[$s_nomFourniseur]['prix_ht'] = ArticleFournisseur::getPrixHt($i_idArticleFournisseur);
                    $o_descriptionArticle[$s_nomFourniseur]['prix_ttc'] = ArticleFournisseur::getPrixTtc($i_idArticleFournisseur);
                }
                // on considère que le montant tva dépend de l'article
                $i_idTva = ArticleCampagne::getIdTva($i_idArticleCampagne);
                $o_descriptionArticle['tva'] = Tva::getValeur($i_idTva);
                // colonnes composées renvoyées à la vue et formatage des nombres
                $o_descriptionArticle['prix_echoppe_ttc_unite'] = number_format($o_descriptionArticle['prix_ttc']/$o_descriptionArticle['poids_paquet_fournisseur'], 2, '.', ' ');
                $o_descriptionArticle[$s_nomFourniseur]['prix_ht'] = number_format($o_descriptionArticle[$s_nomFourniseur]['prix_ht'], 2, '.', ' ');
                $o_descriptionArticle[$s_nomFourniseur]['prix_ttc'] = number_format($o_descriptionArticle[$s_nomFourniseur]['prix_ttc'], 2, '.', ' ');
                $o_descriptionArticle['poids_paquet_fournisseur'] = number_format($o_descriptionArticle['poids_paquet_fournisseur'], 2, '.', ' ');
                $o_descriptionArticle['poids_paquet_client'] = number_format($o_descriptionArticle['poids_paquet_client'], 2, '.', ' ');
            }
        }
        $this->render('gererArticle', compact('to_rayon', 'to_fournisseur', 'i_idRayon', 'to_descriptionArticle'));
    }

    public function modifierArticle() {
        // récupération des variables post
        $id_article = $POST['id_article'];
        $nom_article = $POST['nom_article'];
        $poids_paquet_fournisseur = $POST['poids_paquet_fournisseur'];
        $poids_paquet_client = $POST['poids_paquet_client'];
        $unite = $POST['unite'];
        $nb_paquet_colis = $POST['nb_paquet_colis'];
        $seuil_min = $POST['seuil_min'];
        // modification des fournisseurs
        $prix_ttc_echoppe = $POST['prix_ttc_echoppe'];
        $tva = $POST['tva'];
        $description_courte = $POST['description_courte'];
        $description_longue = $POST['description_longue'];
        
        // redirection vers afficher les articles
        header('Location: '.root.'/rayon.php/afficherRayon');
        /*echo "A FAIRE !";
        return;*/
    }

    public function creerArticle() {
        echo "A FAIRE !";
        return;
    }


    // Action par défaut.
    public function defaultAction() {
        header('Location: '.root.'/rayon.php/afficherRayon');
    }
}
new ArticleController();
?>
