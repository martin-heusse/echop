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

require_once('Model/GererArticle.php');
require_once('Model/ArticleFournisseur.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/Fournisseur.php');
require_once('Model/Categorie.php');

/* Gère les articles */
class ArticleController extends Controller {


    /* Constructeur */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche l'ensemble des articles d'un rayon 
     */
    public function afficherArticle() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        if(!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }
        /* liste de tous les rayons */
        $to_rayon = Rayon::getAllObjects();
        if(isset($_GET['i_erreur'])){
            $i_erreur = $_GET['i_erreur'];
        } else {
            $i_erreur = null;
        }
        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        if(!isset($_GET['i_idRayon'])){
            $s_message = "Choissisez votre rayon !";
            $i_idRayon = null;
            $to_fournisseur = null;
            $to_descriptionArticle = null;
            $to_tva = null;
            $to_unite = null;
        } else {
            $s_message = null;
            /* liste de toutes les descriptions d'un article d'un rayon de la campagne courante */
            $i_idRayon = $_GET['i_idRayon'];
            $to_descriptionArticle = GererArticle::descriptionArticle($i_idCampagne,$i_idRayon);
                /* liste de tous les fournisseurs */
            $to_fournisseur = GererArticle::fournisseurArticle($i_idCampagne,$i_idRayon);
            foreach ($to_descriptionArticle as &$o_descriptionArticle){
                $i_idArticleCampagne = $o_descriptionArticle['id_article_campagne'];
                foreach($to_fournisseur as $o_fournisseur){
                    $i_idFournisseur = $o_fournisseur['id_fournisseur'];
                    $o_articleFournisseur = ArticleFournisseur::getObjectByIdArticleCampagneIdFournisseur($i_idArticleCampagne,$i_idFournisseur);
                    $o_descriptionArticle[$i_idFournisseur]['code'] = $o_articleFournisseur['code'];
                    $o_descriptionArticle[$i_idFournisseur]['prix_fournisseur'] = $o_articleFournisseur['prix_ht']; // prix_ht A CHANGER
                    $o_descriptionArticle[$i_idFournisseur]['prix_ttc_ht'] = $o_articleFournisseur['prix_ttc_ht'];
                    $o_descriptionArticle[$i_idFournisseur]['vente_paquet_unite'] = $o_articleFournisseur['vente_paquet_unite'];
                    $o_descriptionArticle[$i_idFournisseur]['prix_ttc'] = $o_articleFournisseur['prix_ttc'];
                }
            }
            /* liste de toutes les tva */
            $to_tva = Tva::getAllObjects();
            /* liste de toutes les unités */
            $to_unite = Unite::getAllObjects();
            /* AJOUT liste de toutes les catégories */
            $to_categorie = Categorie::getAllObjects();
        }
        $this->render('gererArticle', compact('to_rayon', 'i_idRayon', 'to_fournisseur', 'to_descriptionArticle', 'to_tva', 'to_unite', 'to_categorie', 's_message', 'i_erreur', 'b_historique', 'i_idCampagne'));
    }

    public function modifierArticle() {
       /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        if(!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }
        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        $i_erreur = null;
        if( !isset($_POST['i_idRayon'])
            or !isset($_POST['id_article_campagne'])
            or !isset($_POST['en_vente'])
            or !isset($_POST['nom_produit'])
            or !isset($_POST['description_courte'])
            or !isset($_POST['description_longue'])
            or !isset($_POST['id_unite'])
            or !isset($_POST['nb_paquet_colis'])
            or !isset($_POST['poids_paquet_fournisseur'])
            or !isset($_POST['poids_paquet_client'])
            or !isset($_POST['seuil_min'])
            or !isset($_POST['id_tva'])
            or !isset($_POST['id_Fournisseur_rayon'])
            or !isset($_POST['id_fournisseur_choisi'])
            or !isset($_POST['prix_ttc_echoppe']) ) {
            /* si une des variables n'est pas définie */
            $i_erreur = 1;
            /* Redirection */
            if ($i_idCampagne == Campagne::getIdCampagneCourante()) {
                header('Location: '.root.'/article.php/afficherArticle?i_erreur='.$i_erreur);
            } else {
                header('Location: '.root.'/article.php/afficherArticle?i_erreur='.$i_erreur.'&idOldCampagne='.$i_idCampagne);
            }
        } else {
            /* si toutes les variables sont définies on les récupère */
            $i_idRayon = $_POST['i_idRayon'];
            $ti_idArticleCampagne = $_POST['id_article_campagne'];
            $tb_enVente = $_POST['en_vente'];
            $ts_nomProduit = $_POST['nom_produit'];
            $ts_descriptionCourte = $_POST['description_courte'];
            $ts_descriptionLongue = $_POST['description_longue'];
            $ti_idUnite = $_POST['id_unite'];
            $ti_nbPaquetColis = $_POST['nb_paquet_colis'];
            $tf_poidsPaquetFournisseur = $_POST['poids_paquet_fournisseur'];
            $tf_poidsPaquetClient = $_POST['poids_paquet_client'];
            $ti_seuilMin = $_POST['seuil_min'];
            $ti_idTva = $_POST['id_tva'];
            $ti_idFournisseurRayon = $_POST['id_Fournisseur_rayon'];
            $tf_prixTtcEchoppe = $_POST['prix_ttc_echoppe'];
            $i_nbArticleCampagne = count($ti_idArticleCampagne);
            for ($i=0; $i<$i_nbArticleCampagne; $i++) {
                $i_idArticleCampagne = $ti_idArticleCampagne[$i];
                $i_idArticle = ArticleCampagne::getIdArticle($i_idArticleCampagne);
                /* modification en vente ou pas */
                $b_enVente = $tb_enVente[$i];
                ArticleCampagne::setEnVente($i_idArticleCampagne, $b_enVente);
                /* modification du nom du produit */
                $s_nomProduit = $ts_nomProduit[$i];
                Article::setNom($i_idArticle,$s_nomProduit);
                /* modification de la description courte */
                $s_descriptionCourte = $ts_descriptionCourte[$i];
                Article::setDescriptionCourte($i_idArticle,$s_descriptionCourte);
                /* modification de la description longue */
                $s_descriptionLongue = $ts_descriptionLongue[$i];
                Article::setDescriptionLongue($i_idArticle,$s_descriptionLongue);
                /* modification de l'unité */
                $i_idUnite = $ti_idUnite[$i];
                Article::setIdUnite($i_idArticle, $i_idUnite);
                /* modification du nombre de paquet par colis */
                $i_nbPaquetColis = $ti_nbPaquetColis[$i];
                Article::setNbPaquetColis($i_idArticle, $i_nbPaquetColis);
                /* modification du poids du paquet fournisseur */
                $i_idUnite = $ti_idUnite[$i];
                Article::setIdUnite($i_idArticle, $i_idUnite);
                /* modification du poids paquet client */
                $f_poidsPaquetClient = $tf_poidsPaquetClient[$i];
                ArticleCampagne::setPoidsPaquetClient($i_idArticleCampagne, $f_poidsPaquetClient);
                /* modification du seuil min */
                $i_seuilMin = $ti_seuilMin[$i];
                ArticleCampagne::setSeuilMin($i_idArticleCampagne, $i_seuilMin);
                /* modification de la tva */
                $i_idTva = $ti_idTva[$i];
                ArticleCampagne::setIdTva($i_idArticleCampagne, $i_idTva);
                /* modification des champs d'un fournisseur */
                foreach($ti_idFournisseurRayon as $i_idFournisseurRayon){
                    $i_idArticleFournisseur = ArticleFournisseur::getIdByIdArticleCampagneIdFournisseur($i_idArticleCampagne,$i_idFournisseurRayon);
                    /* modification du code */
                    $s_code = $_POST['code'][$i_idFournisseurRayon][$i];
                    ArticleFournisseur::setCode($i_idArticleFournisseur,$s_code);
                    /* modification du montant */
                    $f_prix_fournisseur = $_POST['montant'][$i_idFournisseurRayon][$i];
                    ArticleFournisseur::setPrixHt($i_idArticleFournisseur,$f_prix_fournisseur);
                    /* modification de vente_paquet_unite */
                    $b_ventePaquetUnite = $_POST['vente_paquet_unite'][$i_idFournisseurRayon][$i];
                    ArticleFournisseur::setVentePaquetUnite($i_idArticleFournisseur,$b_ventePaquetUnite);
                    /* modification de prix_ttc_ht */
                    $b_PrixTtcHt = $_POST['prix_ttc_ht'][$i_idFournisseurRayon][$i];
                    ArticleFournisseur::setPrixTtcHt($i_idArticleFournisseur,$b_PrixTtcHt);
                    /* Calcul du prix ttc */
                    
                }
                /* modification du fournisseur choisi */
                $i_idFournisseurChoisi = $_POST["id_fournisseur_choisi"][$i_idArticleCampagne];
                ArticleCampagne::setIdFournisseur($i_idArticleCampagne, $i_idFournisseurChoisi);
                /* modification du prix choisi par l'échoppe */
                $f_prixTtcEchoppe = $tf_prixTtcEchoppe[$i];
                ArticleCampagne::setPrixTtc($i_idArticleCampagne, $f_prixTtcEchoppe);
                $i_erreur = 0;
            }
        }
        /* Redirection */
        if ($i_idCampagne == Campagne::getIdCampagneCourante()) {
            header('Location: '.root.'/article.php/afficherArticle?i_erreur='.$i_erreur.'&i_idRayon='.$i_idRayon);
        } else {
            header('Location: '.root.'/article.php/afficherArticle?i_erreur='.$i_erreur.'&i_idRayon='.$i_idRayon.'&idOldCampagne='.$i_idCampagne);
        }
    }

    public function afficherCreerArticle() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        if(!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }
        $i_idRayon = $_GET['i_idRayon'];
        $o_rayon = Rayon::getObject($i_idRayon);
        $to_tva = Tva::getAllObjects();
        $to_unite = Unite::getAllObjects();
        $to_fournisseur = Fournisseur::getAllObjects();
        $to_categorie = Categorie::getAllObjects();
        $this->render('creerArticle',compact('o_rayon','to_tva', 'to_unite', 'to_fournisseur','to_categorie'));
    }

    public function creerArticle() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        if(!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }
        $i_erreur = null;
        $to_tva = Tva::getAllObjects();
        $to_unite = Unite::getAllObjects();
        // A CHANGER
        $to_fournisseur = Fournisseur::getAllObjects();
        // récupération des variables
        if( !isset($_POST['nom_produit']) or $_POST['nom_produit']==""
            or !isset($_POST['poids_paquet_fournisseur'])
            or !isset($_POST['poids_paquet_client'])
            or !isset($_POST['id_unite'])
            or !isset($_POST['id_categorie'])
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
        $i_idCategorie = $_POST['id_categorie'];
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
        $i_idArticle = Article::create($i_idRayon, $i_idCategorie, $s_nomProduit, $f_poidsPaquetFournisseur,$i_idUnite, $i_nbPaquetColis, $s_descriptionCourte, $s_descriptionLongue);
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
