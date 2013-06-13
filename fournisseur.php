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
        $o_campagne = Campagne::getCampagneCourante();
        $i_idCampagne = $o_campagne['id'];
        $to_fournisseur = ArticleCampagne::getIdFournisseurByIdCampagne($i_idCampagne);
        foreach ($to_fournisseur as &$o_fournisseur) {
            $i_idFournisseur = $o_fournisseur['id_fournisseur'];
            $o_fournisseur['id'] = $i_idFournisseur;
            $o_fournisseur['nom'] = Fournisseur::getNom($i_idFournisseur);
            $to_articleFournisseur = ArticleCampagne::getObjectsByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur);
            $f_montantTtc = 0;
            $f_montantHt = 0;
            /* pour un fournisseur donné, on récupère tous les articles 
             * commandés*/
            foreach ($to_articleFournisseur as &$o_articleFournisseur) {
                /* pour chaque article, on récupère les données qui vont nous 
                 * permettre de calculer le prix d'achat au fournisseur */
                $i_quantiteTotaleArticle = 0;
                $i_idArticle = $o_articleFournisseur['id_article'];
                $f_poidsPaquetClient = $o_articleFournisseur['poids_paquet_client'];
                $ti_idUtilisateur = Commande::getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                /* pour chaque utilisateur, on regarde combien il a commandé*/
                foreach ($ti_idUtilisateur as $o_idUtilisateur) {
                    $i_idUtilisateur = $o_idUtilisateur['id_utilisateur'];
                    $i_id = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                    $i_quantite = Commande::getQuantite($i_id);
                    $i_quantiteTotaleArticle += $i_quantite;
                }
                $i_quantiteTotaleArticleReelle = $i_quantiteTotaleArticle * $f_poidsPaquetClient;
                /* on cherche le prix du paquet fournisseur*/
                $f_prixTtcArticle = ArticleFournisseur::getPrixTtcByIdArticleIdFournisseur($i_idArticle, $i_idFournisseur);
                $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
                $f_prixTotaleArticle = $i_quantiteTotaleArticleReelle * $f_prixTtcArticle / $i_poidsPaquetFournisseur;
                $f_montantTtc += $f_prixTotaleArticle;
            }
            $o_fournisseur['montant_total'] = $f_montantTtc;
        }
        $this->render('fournisseursChoisis', compact('to_fournisseur'));
    }

    /*
     * Affiche la liste des articles commandés auprès d'un fournisseur pour la 
     * campagne courante.
     */
    public function commandeFournisseur() {
        /* Paramètre GET nécessaire */
        if(!isset($_GET['idFournisseur'])) {
            header('Location: '.root.'/articleCampagne.php/fournisseursChoisis');
            return;
        }
        $i_idFournisseur = $_GET['idFournisseur'];
        $i_idCampagne = Campagne::getIdCampagneCourante();
        $to_article = ArticleCampagne::getObjectsByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur);
        foreach ($to_article as &$o_article) {
            /* pour chaque article, on récupère les données qui vont nous 
             * permettre de connaître la quantité totale et le prix */
            $i_quantiteTotale = 0;
            $i_idArticle = $o_article['id_article'];
            $f_poidsPaquetClient = $o_article['poids_paquet_client'];
            $ti_idUtilisateur = Commande::getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            /* pour chaque utilisateur, on regarde combien il a commandé*/
            foreach ($ti_idUtilisateur as $o_idUtilisateur) {
                $i_idUtilisateur = $o_idUtilisateur['id_utilisateur'];
                $i_id = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                $i_quantite = Commande::getQuantite($i_id);
                $i_quantiteTotale += $i_quantite;
            }
            $o_article['quantite_totale'] = $i_quantiteTotale * $f_poidsPaquetClient;
            /* on cherche le prix du paquet fournisseur*/
            $f_prixTtcArticle = ArticleFournisseur::getPrixTtcByIdArticleIdFournisseur($i_idArticle, $i_idFournisseur);
            $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
            $o_article['montant_total'] = $o_article['quantite_totale'] * $f_prixTtcArticle / $i_poidsPaquetFournisseur;
            $o_article['nom'] = Article::getNom($i_idArticle);
        }
        $this->render('commandeFournisseur', compact('to_article'));
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
