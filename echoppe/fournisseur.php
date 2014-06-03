<?php
require_once('def.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Fournisseur.php');
require_once('Model/Campagne.php');
require_once('Model/Commande.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/Article.php');
require_once('Model/ArticleFournisseur.php');
require_once('Model/Unite.php');

/*
 * Gère les fournisseurs.
 */
class FournisseurController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche la liste de tous les fournisseurs.
     */
    public function tousLesFournisseurs() {
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
        /* Récupère tous les fournisseurs */
        $to_fournisseur = Fournisseur::getAllObjects();
        $this->render('tousLesFournisseurs', compact('to_fournisseur'));
    }

    /*
     * Affiche la liste des fournisseurs choisis pour la campagne courante.
     */
    public function fournisseursChoisis() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        if (!$_SESSION['isAdministrateur']) {
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
        /* on récupère l'ensemble des fournisseurs choisis pour la campagne 
         * donnée */
        $to_fournisseur = ArticleCampagne::getIdFournisseurByIdCampagne($i_idCampagne);
        
        /* Pour chaque fournisseur on va chercher les infos nécéssaires pour 
         * connaitre la somme due au fournisseur */
        foreach ($to_fournisseur as &$o_fournisseur) {
            /* Informations concernant chaque fournisseur */
            $i_idFournisseur = $o_fournisseur['id_fournisseur'];
            $o_fournisseur['id'] = $i_idFournisseur;
            $o_fournisseur['nom'] = Fournisseur::getNom($i_idFournisseur);
            $to_articleFournisseur = ArticleCampagne::getObjectsByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur);
            $f_montantTtc = 0;
            /* pour un fournisseur donné, on récupère tous les articles 
             * commandés*/
            foreach ($to_articleFournisseur as &$o_articleFournisseur) {
                /* pour chaque article, on récupère les données qui vont nous 
                 * permettre de calculer le prix d'achat au fournisseur */
                $i_quantiteTotaleArticle = 0;
                $i_idArticle = $o_articleFournisseur['id_article'];
                $f_poidsPaquetClient = $o_articleFournisseur['poids_paquet_client'];
                $ti_idUtilisateur = Commande::getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                /* pour chaque utilisateur, on regarde combien il a commandé */
                foreach ($ti_idUtilisateur as $i_idUtilisateur) {
                    $i_id = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                    $i_quantite = Commande::getQuantite($i_id);
                    $i_quantiteTotaleArticle += $i_quantite;
                }
                /* On calcule la quantité totale commandée selon l'unité */
                $i_quantiteTotaleArticleReelle = $i_quantiteTotaleArticle * $f_poidsPaquetClient;
                /* on cherche le prix du paquet fournisseur*/
                $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                $f_prixTtcArticle = ArticleFournisseur::getPrixTtcByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
                $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
                $f_prixTotaleArticle = $i_quantiteTotaleArticleReelle * $f_prixTtcArticle / $i_poidsPaquetFournisseur;
                $f_montantTtc += $f_prixTotaleArticle;
            }
            /* Montant du aux fournisseurs */
            $o_fournisseur['montant_total'] = $f_montantTtc;
            /* Formattage des nombres */
            $o_fournisseur['montant_total'] = number_format($o_fournisseur['montant_total'], 2, '.', ' ');
        }
        $this->render('fournisseursChoisis', compact('to_fournisseur', 'b_historique', 'i_idCampagne'));
    }

    /*
     * Affiche la liste des articles commandés auprès d'un fournisseur pour la 
     * campagne courante.
     */
    public function commandeFournisseur() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        if (!$_SESSION['isAdministrateur']) {
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
        /* On récupère l'identifiant du fournisseur */
        if(!isset($_GET['idFournisseur'])) {
            header('Location: '.root.'/articleCampagne.php/fournisseursChoisis');
            return;
        }
        $i_idFournisseur = $_GET['idFournisseur'];
        /* On récupère les articles qui vont être acheté aux fournisseurs */
        $to_article = ArticleCampagne::getObjectsByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur);
        /* On regarde le nombre d'article commandés à ce fournisseur */
            $i_nbreArticle = 0;
        foreach ($to_article as &$o_article) {
            /* pour chaque article, on récupère les données qui vont nous 
             * permettre de connaître la quantité totale et le prix */
            $i_quantiteTotale = 0;
            $i_idArticle = $o_article['id_article'];
            $f_poidsPaquetClient = $o_article['poids_paquet_client'];
            $ti_idUtilisateur = Commande::getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            /* pour chaque utilisateur, on regarde combien il a commandé*/
            foreach ($ti_idUtilisateur as $i_idUtilisateur) {
                $i_nbreArticle++;
                $i_id = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                $i_quantite = Commande::getQuantite($i_id);
                $i_quantiteTotale += $i_quantite;
            }
            $o_article['quantite_totale'] = $i_quantiteTotale * $f_poidsPaquetClient;
            $o_article['quantite_totale_unites'] = $i_quantiteTotale;
            /* on calcule le prix du paquet fournisseur*/
            $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $f_prixTtcArticle = ArticleFournisseur::getPrixTtcByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
            $o_article['montant_total'] = $o_article['quantite_totale'] * $f_prixTtcArticle / $i_poidsPaquetFournisseur;
            $o_article['nom'] = Article::getNom($i_idArticle);
            $i_idUnite = Article::getIdUnite($i_idArticle);
            $o_article['unite'] = Unite::getValeur($i_idUnite);
            
            
            /* Récupération du Code Fournisseur, 1&2 cahier des charges */
            //$i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idFournisseur = ArticleCampagne::getIdFournisseur($i_idArticleCampagne);
            //$o_article_fournisseur = ArticleFournisseur::getObjectByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $i_idArticleFournisseur = ArticleFournisseur::getIdByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $o_article['code'] = ArticleFournisseur::getCode($i_idArticleFournisseur);
            
            /* Calcul du prix unitaire 1&2 cahier des charges */
            $o_article_campagne = ArticleCampagne::getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idArticleFournisseur = ArticleFournisseur::getIdByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $o_article['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
            $o_article['prix_ttc'] = $o_article_campagne['prix_ttc'];
            $o_article['seuil_min'] = $o_article_campagne['seuil_min'];
            $o_article['poids_paquet_client'] = $o_article_campagne['poids_paquet_client'];
            /* Valeurs calculées */
            /* Calcul poids unitaire */
            $o_article['prix_unitaire'] = $o_article['prix_ttc'] / $o_article['poids_paquet_fournisseur'];
            $o_article['prix_unitaire_client'] = $o_article['prix_unitaire'] * $o_article['poids_paquet_client'];
            
            $o_article['prix_unitaire_client'] = number_format($o_article['prix_unitaire_client'], 2, '.', '');
            $o_article['prix_unitaire'] = number_format($o_article['prix_unitaire'], 2, '.', '');
            $o_article['montant_total'] = number_format($o_article['montant_total'], 2, '.', '');
            $o_article['prix_ht'] = ArticleFournisseur::getPrixHt($i_idArticleFournisseur);
            $o_article['prix_ttc'] = ArticleFournisseur::getPrixTtc($i_idArticleFournisseur);
            $o_article['prix_ttc_ht'] = ArticleFournisseur::getPrixTtcHt($i_idArticleFournisseur);
            $o_article['vente_paquet_unite'] = ArticleFournisseur::getVentePaquetUnite($i_idArticleFournisseur);


        }
        $this->render('commandeFournisseur', compact('to_article', 'i_nbreArticle', 'b_historique', 'i_idCampagne'));
    }

    /*
     *  Gère les fournisseurs
     */
    public function gererFournisseur() {

        /* On récupère le nom du fournisseur tapé par l'utilisateur */
        if (isset($_POST['nom_fournisseur']) && $_POST['nom_fournisseur'] != "") {
            $s_nom = $_POST['nom_fournisseur'];

            /* Vérification de la pré-existence: on interdit que le nom n'existe 
                * pas déjà */
            $o_fournisseur = Fournisseur::getObjectByNom($s_nom);
            if ($o_fournisseur == array()) {
                Fournisseur::create($s_nom);
            }
        }
        /* On récupère le nom de tous les fournisseurs pour les afficher */
            $to_nom = Fournisseur::GetAllObjects();
            $this->render('gererFournisseur', compact('to_nom'));
            return;
    }

    /*
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/fournisseur.php/tousLesFournisseurs');
    }
}
new FournisseurController();
?>
