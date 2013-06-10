<?php
require_once('def.php');
require_once('Model/Commande.php');
require_once('Model/Campagne.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Article.php');
require_once('Model/Unite.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/Rayon.php');
require_once('Model/Fournisseur.php');

/*
 * Gère les commandes.
 */
class CommandeController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche les commandes de l'utilisateur courant.
     */
    public function mesCommandes() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = Campagne::getIdCampagneCourante();
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur = $_SESSION['idUtilisateur'];
        $to_commande = Commande::getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);

        /* récupération de tous les attributs nécessaires d'un article */
        foreach($to_commande as &$o_article) {
            /* Attributs dépendant de l'article */
            $i_idArticle = $o_article['id_article'];
            $o_article['nom'] = Article::getNom($i_idArticle);
            $o_article['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
            $i_idUnite = Article::getIdUnite($i_idArticle);
            $o_article['unite'] = Unite::getUnite($i_idUnite);
            $o_article['nb_paquet_colis'] = Article::getNbPaquetColis($i_idArticle);
            $o_article['description_courte'] = Article::getDescriptionCourte($i_idArticle);
            $o_article['description_longue'] = Article::getDescriptionLongue($i_idArticle);
            /* Prix TTC, seuil min et poids paquet client */
            $o_article_campagne = ArticleCampagne::getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $o_article['prix_ttc'] = $o_article_campagne['prix_ttc'];
            $o_article['seuil_min'] = $o_article_campagne['seuil_min'];
            $o_article['poids_paquet_client'] = $o_article_campagne['poids_paquet_client'];

            /* Valeurs calculées */
            /* Calcul poids unitaire */
            $o_article['prix_unitaire'] = $o_article['prix_ttc'] / $o_article['poids_paquet_fournisseur'];
            /* Calcul quantité totale */
            $o_article['quantite_totale'] = $o_article['quantite'] * $o_article['poids_paquet_client'];
            /* Calcul total TTC */
            $o_article['total_ttc'] = $o_article['quantite_totale'] * $o_article['prix_ttc'] / $o_article['poids_paquet_fournisseur'];
        }
        $this->render('mesCommandes', compact('to_commande', 'b_etat'));
    }

    /*
     * Gère la modification des quantités dans la commande de l'utilisateur 
     * courant.
     */
    public function modifierQuantite() {
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = Campagne::getIdCampagneCourante();
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* La campagne est fermée */
        if ($b_etat == 0) {
            header('Location: '.root.'/commande.php/mesCommandes');
            return;
        }
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur =  $_SESSION['idUtilisateur'];
        /* Récupération des articles de l'utilisateur */
        $ti_article = Commande::getIdArticleByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);
        /* Pour chaque article on modifie la quantité si nécéssaire */
        foreach($ti_article as &$i_article) {
            $i_idArticle = $i_article['id_article'];
            /* Si des modifications ont été faite par l'utilisateur, on traite l'entrée */
            if (isset($_POST['quantite'])){
                $ti_quantite = $_POST['quantite'];
                $i_quantite = $ti_quantite[$i_idArticle];
                $i_seuilMin = ArticleCampagne::getSeuilMinByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                /* Si la quantité est supérieur au seuil min et non nulle, on 
                 * actualise, sinon on ne fait rien */
                if ($i_quantite != 0 && $i_quantite >= $i_seuilMin) {
                    $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                    Commande::setQuantite($i_idCommande, $i_quantite);
                }
            }	
        }
        header('Location: '.root.'/commande.php/mesCommandes');
    }

    /*
     * Supprime l'article.
     */
    public function supprimerArticle() {
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = Campagne::getIdCampagneCourante();
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* La campagne est fermée */
        if ($b_etat == 0) {
            header('Location: '.root.'/commande.php/mesCommandes');
            return;
        }
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur =  $_SESSION['idUtilisateur'];
        /* Récupération de l'id article à supprimer */
        $i_idArticle = $_GET['id_article'];
        $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
        Commande::delete($i_idCommande);
        header('Location: '.root.'/commande.php/mesCommandes');
    }

    /* Code Johann <3 */

    public function commanderArticle() {


        $to_rayon = Rayon::getAllObjects();
        $to_article = null;
        /* Sélection d'un rayon pour une commande */
        if (!isset($_POST['commande'])) {
            if (isset($_GET['idRayon'])) {
                $i_idRayon = $_GET['idRayon'];
                $to_article = Article::getObjectsByIdRayon($i_idRayon);
            }
        } else {
            /* Saisie des quantités dans un rayon */
            foreach ($_POST['commande'] as $i_idArticle => $i_qte) {
                $o_commande = Commande::getObjectsbyIdArticleIdCampagne($i_idArticle, $i_idCampagne);   

                $i_idCommande = $o_commande['id'];     
                $i_idUtilisateur = $o_commande['utilisateur'];

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
                    }
                } else {
                    if ($i_newQte > 0) {
                        Commande::setQuantite($i_idCommande, $i_newQte);
                    } else {
                        Commande::delete($i_idCommande);
                    }
                }
            }
        }
        $this->render('commanderArticle', compact('to_rayon','to_article'));
    }

    public function utilisateurAyantCommandE(){  
        $i_idCampagne = Campagne::getIdCampagneCourante();
        $to_commande = Commande::getIdUtilisateurUniqueByIdCampagne($i_idCampagne);
        foreach($to_commande as &$o_article) {
            $i_idUtilisateur = $o_article['id_utilisateur'];
            $o_article['login_utilisateur'] = Utilisateur::getLogin($i_idUtilisateur);
        }
        $this->render('utilisateurAyantCommandE', compact('to_commande'));	
    }


    public function commandeUtilisateur(){

        $i_idUtilisateur = $_GET['id_utilisateur'];
        $i_idCampagne = Campagne::getIdCampagneCourante();
        $to_commandeUtilisateur = Commande::getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);

        foreach($to_commandeUtilisateur as &$o_article) {

            $i_idArticle = $o_article['id_article'];
            $o_article['nom'] = Article::getNom($i_idArticle);
            $o_article['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
            $i_idUnite = Article::getIdUnite($i_idArticle);
            $o_article['unite'] = Unite::getUnite($i_idUnite);
            $o_article['nb_paquet_colis'] = Article::getNbPaquetColis($i_idArticle);
            $o_article['description_courte'] = Article::getDescriptionCourte($i_idArticle);
            $o_article['description_longue'] = Article::getDescriptionLongue($i_idArticle);
            // prix ttc
            $o_article_campagne = ArticleCampagne::getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $o_article['prix_ttc'] = $o_article_campagne['prix_ttc'];
            $o_article['seuil_min'] = $o_article_campagne['seuil_min'];
            // poids paquet client
            $o_article['poids_paquet_client'] = $o_article_campagne['poids_paquet_client'];
            //calcul poids unitaire
            $o_article['prix_unitaire']=$o_article['prix_ttc']/$o_article['poids_paquet_fournisseur'];
            //calcul quantite totale
            $o_article['quantite_totale']=$o_article['quantite']*$o_article['poids_paquet_client'];
            // calcul total ttc
            $o_article['total_ttc']=$o_article['quantite_totale']*$o_article['prix_ttc']/$o_article['poids_paquet_fournisseur'];

            // recherche du login 
            $s_login=Utilisateur::getLogin($i_idUtilisateur);
        }
        $this->render('commandeUtilisateur', compact('to_commandeUtilisateur', 's_login'));
    }

    public function articlesCommandEs() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        $o_campagne = Campagne::getCampagneCourante();
        $i_idCampagne = $o_campagne['id'];
        $to_article = Commande::getIdArticleByIdCampagne($i_idCampagne);
        foreach ($to_article as &$o_row) {
            $o_row['nom'] = Article::getNom($o_row['id_article']);
        }
        $this->render('articlesCommandEs', compact('to_article'));
    }

    public function utilisateursAyantCommandECetArticle() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Paramètre GET nécessaire */
        if(!isset($_GET['idArticle'])) {
            header('Location: '.root.'/commande.php/articlesCommandEs');
            return;
        }
        $i_idArticle = $_GET['idArticle'];
        $o_campagne = Campagne::getCampagneCourante();
        $i_idCampagne = $o_campagne['id'];
        $to_utilisateur = Commande::getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
        foreach ($to_utilisateur as &$o_row) {
            $o_row['login'] = Utilisateur::getLogin($o_row['id_utilisateur']);
            $o_row['id'] = $o_row['id_utilisateur'];
        }
        $this->render('utilisateursAyantCommandECetArticle', compact('to_utilisateur'));
    }

    public function defaultAction() {
        header('Location: '.root.'/commande.php/mesCommandes');
    }
}
new CommandeController();
?>
