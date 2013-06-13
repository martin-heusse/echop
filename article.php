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
        // liste de toutes les tva
        $to_tva = Tva::getAllObjects();
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
                $o_descriptionArticle[$i_idFournisseur]['prix_ht'] = number_format($o_descriptionArticle[$i_idFournisseur]['prix_ht'], 2, '.', ' ');
                $o_descriptionArticle[$i_idFournisseur]['prix_ttc'] = number_format($o_descriptionArticle[$i_idFournisseur]['prix_ttc'], 2, '.', ' ');
                $o_descriptionArticle['poids_paquet_fournisseur'] = number_format($o_descriptionArticle['poids_paquet_fournisseur'], 2, '.', ' ');
                $o_descriptionArticle['poids_paquet_client'] = number_format($o_descriptionArticle['poids_paquet_client'], 2, '.', ' ');
            }
        }
        $this->render('gererArticle', compact('to_rayon', 'to_fournisseur', 'i_idRayon', 'to_descriptionArticle', 'to_tva'));
    }

    public function modifierArticle() {
        // récupération des tableaux
        $ti_idArticleCampagne = $_POST['id_article_campagne'];
        $ti_poisPaquetClient = $_POST['poids_paquet_client'];
        $ti_seuilMin = $_POST['seuil_min'];
        $i_nbArticleCampagne = count($ti_idArticleCampagne);
        for ($i=0; $i<$i_nbArticleCampagne; $i++) {
        // pour tous les articles campagnes
        // on récupère les variables en méthode post
        
        }
        header('Location: '.root.'/rayon.php/afficherRayon');
        //echo "A FAIRE !";
        //return;
    }

    public function afficherCreerArticle() {
        $to_tva = Tva::getAllObjects();
        $to_unite = Unite::getAllObjects();
        $to_fournisseur = Fournisseur::getAllObjects();
        $this->render('creerArticle',compact('to_tva', 'to_unite', 'to_fournisseur'));
    }

    public function creerArticle() {
        $i_erreur = null;
        $to_tva = Tva::getAllObjects();
        $to_unite = Unite::getAllObjects();
        $to_fournisseur = Fournisseur::getAllObjects();
        // récupération des variables
        if( !isset($_POST['nom_produit']) or $_POST['nom_produit']==""
            or !isset($_POST['poids_paquet_fournisseur'])
            or !isset($_POST['poids_paquet_client'])
            or !isset($_POST['id_unite'])
            or !isset($_POST['nb_paquet_colis'])
            or !isset($_POST['seuil_min'])
            or !isset($_POST['id_fournisseur'])
            or !isset($_POST['code'])
            or !isset($_POST['prix_ttc_fournisseur'])
            or !isset($_POST['prix_ht'])
            or !isset($_POST['id_tva'])
            or !isset($_POST['prix_ttc_echoppe'])
            or !isset($_POST['description_courte'])
            or !isset($_POST['description_longue']) ){
            // si une des variables n'est pas définie
            $i_erreur = 1;
        } else {
            // si toutes les variables sont définies
        $s_nomProduit = $_POST['nom_produit'];
        $f_poidsPaquetFournisseur = $_POST['poids_paquet_fournisseur'];
        $f_poidsPaquetClient = $_POST['poids_paquet_client'];
        $i_idUnite = $_POST['id_unite'];
        $i_nbPaquetColis = $_POST['nb_paquet_colis'];
        $i_seuilMin = $_POST['seuil_min'];
            // liste des fournisseurs A FAIRE
        $i_idFournisseur = $_POST['id_fournisseur'];
        $s_code = $_POST['code'];
        $f_prixTtcFournisseur = $_POST['prix_ttc_fournisseur'];
        $f_prixHt = $_POST['prix_ht'];
            // fin de la liste
        $i_idTva = $_POST['id_tva'];
        $f_prixTtcEchoppe = $_POST['prix_ttc_echoppe'];
        $s_descriptionCourte = $_POST['description_courte'];
        $s_descriptionLongue = $_POST['description_longue'];
        // par défaut on choisi le rayon 1
        $i_idRayon = 1;
        $i_idArticle = Article::create($i_idRayon, $s_nomProduit, $f_poidsPaquetFournisseur,$i_idUnite, $i_nbPaquetColis, $s_descriptionCourte, $s_descriptionLongue);
        $i_idCampagne = Campagne::getIdCampagneCourante();
        // Normalement ici $i_idFournisseur est celui du fournisseur choisi par l'échoppe A CHANGER
        ArticleCampagne::create($i_idArticle, $i_idCampagne, $i_idFournisseur, $i_idTva, $f_poidsPaquetClient, $i_seuilMin, $f_prixTtcEchoppe);
        // Normalement ici liste des fournisseurs à créer A CHANGER
        ArticleFournisseur::create($i_idArticle, $i_idFournisseur, $f_prixHt, $f_prixTtcFournisseur, $s_code);
        // on redonne à la vue toutes les variables
        $i_erreur = 0;
        }
        $this->render('creerArticle',compact('i_erreur', 'to_tva', 'to_unite', 'to_fournisseur'));
    }


    // Action par défaut.
    public function defaultAction() {
        header('Location: '.root.'/rayon.php/afficherRayon');
    }
}
new ArticleController();
?>
