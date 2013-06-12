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
                    $i_idFournisseur = $o_articleFournisseur['id_fournisseur'];
                    $o_descriptionArticle[$i_idFournisseur]['code'] = $o_articleFournisseur['code'];
                    $o_descriptionArticle[$i_idFournisseur]['prix_ht'] = $o_articleFournisseur['prix_ht'];
                    $o_descriptionArticle[$i_idFournisseur]['prix_ttc'] = $o_articleFournisseur['prix_ttc'];
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
        $i_idArticleCampagne = $_POST['id_article_campagne'];
        $s_nomArticle = $_POST['nom_article'];
        $f_poidsPaquetFournisseur = $_POST['poids_paquet_fournisseur'];
        $f_poidsPaquetClient = $_POST['poids_paquet_client'];
        $s_unite = $_POST['unite'];
        $i_nbPaquetColis = $_POST['nb_paquet_colis'];
        $i_seuilMin = $_POST['seuil_min'];
        // modification des fournisseurs
        $f_prixTtcEchoppe = $_POST['prix_ttc_echoppe'];
        $f_tva = $_POST['tva'];
        $s_descriptionCourte = $_POST['description_courte'];
        $s_descriptionLongue = $_POST['description_longue'];
        // Les modifications à faire dans la base de données.
        // Dans la table article_campagne
        // pour l'instant l'id fournisseur ne change pas
        // modification de la tva
        $i_idTva = ArticleCampagne::getIdTva($i_idArticleCampagne);
        Tva::setValeur($id_idTva,$f_tva);
        /*// Dans la table article dans l'ordre des champs :
        // modification de unite
        $i_idUnite = Article::getIdUnite($i_idArticle);
        Unite::setValeur($i_idUnite, $s_unite);
        // modification de id_rayon pas modifiable
        Article::setNom($i_idArticle,$s_nomArticle);
        Article::setPoidsPaquetFournisseur($i_idArticle,$f_poidsPaquetFournisseur);
        Article::setNbPaquetColis($i_idArticle,$i_nbPaquetColis);
        Article::setDescriptionCourte($i_idArticle,$s_descriptionCourte);
        Article::setDescriptionLongue($i_idArticle,$s_descriptionLongue);*/
        // Dans la table article_fournisseur
        // redirection vers afficher les articles
        header('Location: '.root.'/rayon.php/afficherRayon');
        echo "A FAIRE !";
        return;
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
