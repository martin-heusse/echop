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
        if(isset($_GET['i_erreur'])){
            $i_erreur = $_GET['i_erreur'];
        } else {
            $i_erreur = null;
        }
        // liste de tous les fournisseurs
        $to_fournisseur = Fournisseur::getAllObjects();
        // liste de toutes les tva
        $to_tva = Tva::getAllObjects();
        // liste des descriptions des articles (à partir des tables  :
        // article, article_fournisseur et article_campagne)
        $to_descriptionArticle = array();
        $ts_nomFourniseur = array();
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
            $o_descriptionArticle['id_tva_choisi'] = ArticleCampagne::getIdTva($i_idArticleCampagne);
            // colonnes composées renvoyées à la vue et formatage des nombres
            $o_descriptionArticle['prix_echoppe_ttc_unite'] = number_format($o_descriptionArticle['prix_ttc']/$o_descriptionArticle['poids_paquet_fournisseur'], 2, '.', ' ');
        }
        $this->render('gererArticle', compact('to_rayon', 'to_fournisseur', 'i_idRayon', 'to_descriptionArticle', 'to_tva','i_erreur'));
        /*
        // Campagne courante
        $i_idCampagneCourante = Campagne::getIdCampagneCourante();
        // Articles de la campagne courante
        $ti_idArticle = ArticleCampagne::getIdArticleByIdCampagne($i_idCampagnecourante);
        // Tableau final qui va contenir tous les articles avec les infos
        $to_articleCampagne = array();
        foreach ($ti_idArticle as $i_idArticle) {
            // idArticleCampagne de l'article
            $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagneCourante);
            // Données dans ArticleCampagne
            $o_articleCampagne = ArticleCampagne::getObjects($i_idArticleCampagne);
            // Données dans Article
            // Ajout dans le tableau
            $to_articleCampagne[] = $o_articleCampagne;
        }
        $this->render('gererArticle', compact('to_articleCampagne'));
         */
    }

    public function modifierArticle() {
        $i_erreur = null;
        if( !isset($_POST['id_article_campagne'])
            or !isset($_POST['en_vente'])
            or !isset($_POST['poids_paquet_client'])
            or !isset($_POST['seuil_min'])
            // a faire à régler
            //or !isset($_POST['id_fournisseur_choisi'])
            or !isset($_POST['id_tva'])
            or !isset($_POST['prix_ttc_echoppe']) ) {
            // si une des variables n'est pas définie
            $i_erreur = 1;
        } else {
            // si toutes les variables sont définies on les récupère
            $ti_idArticleCampagne = $_POST['id_article_campagne'];
            $tb_enVente = $_POST['en_vente'];
            $tf_poidsPaquetClient = $_POST['poids_paquet_client'];
            $ti_seuilMin = $_POST['seuil_min'];
            $ti_idTva = $_POST['id_tva'];
            $tf_prixTtcEchoppe = $_POST['prix_ttc_echoppe'];
            $i_nbArticleCampagne = count($ti_idArticleCampagne);
            for ($i=0; $i<$i_nbArticleCampagne; $i++) {
                $i_idArticleCampagne = $ti_idArticleCampagne[$i];
                // modification du en vente
                if($tb_enVente[$i] == "vrai"){
                    $b_enVente = '1';
                } else {
                    $b_enVente = '0';
                }
                ArticleCampagne::setEnVente($i_idArticleCampagne, $b_enVente);
                // modification du poids paquet client
                $f_poidsPaquetClient = $tf_poidsPaquetClient[$i];
                ArticleCampagne::setPoidsPaquetClient($i_idArticleCampagne, $f_poidsPaquetClient);
                // modification du seuil min
                $i_seuilMin = $ti_seuilMin[$i];
                ArticleCampagne::setSeuilMin($i_idArticleCampagne, $i_seuilMin);
                // modification du fournisseur choisi
                $i_idFournisseurChoisi = $_POST["id_fournisseur_choisi"][$i_idArticleCampagne];
                ArticleCampagne::setIdFournisseur($i_idArticleCampagne, $i_idFournisseurChoisi);
                // modification de la tva
                $i_idTva = $ti_idTva[$i];
                ArticleCampagne::setIdTva($i_idArticleCampagne, $i_idTva);
                // modification du prix choisi par l'échoppe
                $f_prixTtcEchoppe = $tf_prixTtcEchoppe[$i];
                ArticleCampagne::setPrixTtc($i_idArticleCampagne, $f_prixTtcEchoppe);
                $i_erreur = 0;
            }
        }
        header("Location: ".root."/article.php/afficherArticle?i_erreur=$i_erreur");
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
            // gestion des fournisseurs
            or !isset($_POST['id_fournisseur_choisi'])
                // ici id_fournisseur est un tableau contenant tous les id_fournisseur du formulaire
            or !isset($_POST['id_fournisseur'])
                // ici code, prix_ttc_fournisseur et prix_ht sont des tableaux
            or !isset($_POST['code'])
            or !isset($_POST['prix_ttc_fournisseur'])
            or !isset($_POST['prix_ht'])
            // fin de la gestion des fournisseur
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
        $i_idFournisseurChoisi = $_POST['id_fournisseur_choisi'];
        $ti_idFournisseur = $_POST['id_fournisseur'];
        $ts_code = $_POST['code'];
        $tf_prixTtcFournisseur = $_POST['prix_ttc_fournisseur'];
        $tf_prixHt = $_POST['prix_ht'];
            // fin de la liste
        $i_idTva = $_POST['id_tva'];
        $f_prixTtcEchoppe = $_POST['prix_ttc_echoppe'];
        $s_descriptionCourte = $_POST['description_courte'];
        $s_descriptionLongue = $_POST['description_longue'];
        // par défaut on choisi le rayon 1
        $i_idRayon = 1;
        $i_idArticle = Article::create($i_idRayon, $s_nomProduit, $f_poidsPaquetFournisseur,$i_idUnite, $i_nbPaquetColis, $s_descriptionCourte, $s_descriptionLongue);
        $i_idCampagne = Campagne::getIdCampagneCourante();
        // $i_idFournisseurChoisi est l'identifiant du fournisseur choisi par l'échoppe
        ArticleCampagne::create($i_idArticle, $i_idCampagne, $i_idFournisseurChoisi, $i_idTva, $f_poidsPaquetClient, $i_seuilMin, $f_prixTtcEchoppe);
        // Normalement ici liste des fournisseurs à créer 
        $i_nbFournisseur = count($ti_idFournisseur);
        for($i = 0; $i < $i_nbFournisseur; $i++){
            $i_idFournisseur = $ti_idFournisseur[$i];
            $f_prixHt = $tf_prixHt[$i];
            $f_prixTtcFournisseur = $tf_prixTtcFournisseur[$i];
            $s_code = $ts_code[$i];
            ArticleFournisseur::create($i_idArticle, $i_idFournisseur, $f_prixHt, $f_prixTtcFournisseur, $s_code);
        }
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
