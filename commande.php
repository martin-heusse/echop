<?php
require_once('def.php');
require_once('Model/Commande.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Article.php');

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
            // $o_article['unite'] = Article::getUnite($i_idArticle);
            $o_article['nb_paquet_colis'] = Article::getNbPaquetColis($i_idArticle);
            $o_article['description_courte'] = Article::getDescriptionCourte($i_idArticle);
            $o_article['description_longue'] = Article::getDescriptionLongue($i_idArticle);
        }
	    $this->render('mesCommandes', compact('to_commande'));
    }

    /* */

    /* Code Johann <3 */

    public function commanderArticle() {
    }

    /* */

    public function defaultAction() {
        header('Location: '.root.'/commande.php/mesCommandes');
    }
}
new CommandeController();
?>
