<?php
require_once('def.php');
require_once('Model/Campagne.php');
require_once('Model/Commande.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/Fournisseur.php');
require_once('Model/Article.php');

/*
 * Gère le modèle ArticleCampagne.
 */
class ArticleCampagneController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
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
        $to_article = ArticleCampagne::getIdArticleByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur);
        foreach ($to_article as &$o_article) {
            $i_idArticle = $o_article['id_article'];
            $o_article['nom'] = Article::getNom($i_idArticle);
        }
        $this->render('commandeFournisseur', compact('to_article'));
    }

    /* 
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/articleCampagne.php/fournisseursChoisis');
    }
}
new ArticleCampagneController();
?>
