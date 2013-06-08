<?php
require_once('def.php');
require_once('Model/Commande.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Article.php');
require_once('Model/Unite.php');
require_once('Model/ArticleCampagne.php');

class CommandeController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    /* Code Aurore */

    public function mesCommandes() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        $to_commande = Commande::getObjectsByIdUtilisateur($_SESSION['idUtilisateur']);
        foreach($to_commande as &$o_article) {
            $i_idArticle = $o_article['id_article'];
            $o_article['nom'] = Article::getNom($i_idArticle);
            $o_article['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
	        $i_idUnite = Article::getIdUnite($i_idArticle);
	        $o_article['unite'] = Unite::getUnite($i_idUnite);
            $o_article['nb_paquet_colis'] = Article::getNbPaquetColis($i_idArticle);
            $o_article['description_courte'] = Article::getDescriptionCourte($i_idArticle);
            $o_article['description_longue'] = Article::getDescriptionLongue($i_idArticle);
	    // prix ttc
	    $i_idCampagne = $o_article['id_campagne'];
	    $o_article_campagne = ArticleCampagne::getObjectsByIdCampagneIdArticle($i_idCampagne, $i_idArticle);
	    $o_article['prix_ttc'] = $o_article_campagne['prix_ttc'];
	    // poids paquet client
	    $o_article['poids_paquet_client'] = $o_article_campagne['poids_paquet_client'];
	    //calcul poids unitaire
	    $o_article['prix_unitaire']=$o_article['prix_ttc']/$o_article['poids_paquet_fournisseur'];
	    //calcul quantite totale
	    $o_article['quantite_totale']=$o_article['quantite']*$o_article['poids_paquet_client'];
	    // calcul total ttc
	    $o_article['total_ttc']=$o_article['quantite_totale']*$o_article['prix_ttc']/$o_article['poids_paquet_fournisseur'];
	    
        }
        $this->render('mesCommandes', compact('to_commande'));
    }

    /* */

    /* Code Johann <3 */

    public function commanderArticle() {
        $i_idRayon = 1;
        
        /* Sélection d'un rayon pour une commande */
        if (!isset($_POST['commande'])) {
            $to_article = Article::getObjectsByIdRayon($i_idRayon);   
            $this->render('commanderArticle',compact('$to_article'));
        } else {

            /* Saisie de quantités dans un rayon */
           foreach ($_POST['commande'] as $i_idArticle => $i_qte) {
                $o_commande = Commande::getObjectsbyIdArticleIdCampagne($i_idArticle, $i_idCampagne);   
                
                $i_idCommande = o_row['id'];     
                $i_idUtilisateur = o_row['utilisateur'];

                /* Détermination des paramètes pour la requete SQL */
                $i_oldQte = Commande::getQuantite($i_idCommande);
                $i_newQte = $i_qte;
                $o_Utilisateur = getOBjectByLogin($S_SESSION['login']);
                $i_idUtilisateur = $o_Utilisateur['id'];

                /* Insertion, MAJ ou Suppression de la BDD */
                if ($i_oldQte == 0) {
                    if ($i_newQte > 0) {
                        Commande::create($i_idArticle, $i_idCampagne,
                                         $i_idUtilisateur, $i_newQte);
                } else {
                    if ($i_newQte > 0) {
                        Commande::setQuantite();
                    } else {
                        Commande::delete();
                    }
                }
            }
            /* */

            public function defaultAction() {
                header('Location: '.root.'/commande.php/mesCommandes');
            }
        }
        new CommandeController();
?>
