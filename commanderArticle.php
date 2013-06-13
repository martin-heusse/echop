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
 * Gère "Commander article" en tant qu'utilisateur.
 */
class CommanderArticleController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /* Affiche la liste des rayons */
    public function afficherRayon() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = Campagne::getIdCampagneCourante();
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        $to_rayon = Rayon::getAllObjects();
        $this->render('commanderArticle', compact('to_rayon','b_etat'));
    }
    /* 
     * Affiche la liste des articles par rayon.
     * L'utilisateur a la possibilité de commander des articles.
     */
    public function commanderArticle() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = Campagne::getIdCampagneCourante();
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        $to_rayon = Rayon::getAllObjects();
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur = $_SESSION['idUtilisateur'];

        if (!isset($_GET['idRayon'])) {	
            $this->render('afficherRayon');
            return;
        }
        $i_idRayon = $_GET['idRayon'];
        echo 'id_rayon';
        echo $i_idRayon;
        $to_commande = ArticleCampagne::getObjectsByIdCampagne($i_idCampagne);
        /* Montant total */
        $f_montantTotal = 0;
        /* Récupération de tous les attributs nécessaires d'un article */
        foreach($to_commande as &$o_article) {
            /* Attributs dépendant de l'article */
            $i_idArticle = $o_article['id_article'];
            $o_article['id_rayon'] = Article::getIdRayon($i_idArticle);
            if ($o_article['id_rayon'] == $i_idRayon) {
                $o_article['nom'] = Article::getNom($i_idArticle);
                $o_article['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
                $i_idUnite = Article::getIdUnite($i_idArticle);
                $o_article['unite'] = Unite::getUnite($i_idUnite);
                $o_article['nb_paquet_colis'] = Article::getNbPaquetColis($i_idArticle);
                $o_article['description_courte'] = Article::getDescriptionCourte($i_idArticle);
                $o_article['description_longue'] = Article::getDescriptionLongue($i_idArticle);
                /* Quantité */
                $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                $o_article['quantite'] = Commande::getQuantite($i_idCommande); 

                /* Valeurs calculées */
                /* Calcul poids unitaire */
                $o_article['prix_unitaire'] = $o_article['prix_ttc'] / $o_article['poids_paquet_fournisseur'];
                $o_article['prix_unitaire'] = number_format($o_article['prix_unitaire'], 2, '.', ' ');
                /* Calcul quantité totale */
                $o_article['quantite_totale'] = $o_article['quantite'] * $o_article['poids_paquet_client'];
                $o_article['quantite_totale'] = number_format($o_article['quantite_totale'], 2, '.', ' ');
                /* Calcul total TTC */
                $o_article['total_ttc'] = $o_article['quantite_totale'] * $o_article['prix_ttc'] / $o_article['poids_paquet_fournisseur'];
                $o_article['total_ttc'] = number_format($o_article['total_ttc'], 2, '.', ' ');
                /* Calcul du montant total */
                $f_montantTotal += $o_article['total_ttc'];
                $f_montantTotal = number_format($f_montantTotal, 2, '.', ' ');
            }
        }
        $this->render('commanderArticle', compact('to_commande', 'b_etat', 'f_montantTotal', 'to_rayon', 'i_idRayon'));
    }

    /*
     * Gère la modification des quantités pour "commander articles" dans la 
     * commande de l'utilisateur courant.
     */
    public function commanderArticleModifier() {
        if (!isset($_GET['idRayon'])) {	
            echo 'ici c get';
            $this->render('afficherRayon');
            return;
        }
        echo 'idRayon dans modification d article';
        $i_idRayon = $_GET['idRayon'];
        echo $_GET['idRayon']; 
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = Campagne::getIdCampagneCourante();
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* La campagne est fermée */
        if ($b_etat == 0) {
            header('Location: '.root.'/commanderArticle.php/commanderArticle?idRayon='.$i_idRayon);
            return;
        }
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur = $_SESSION['idUtilisateur'];
        /* Récupération des articles de l'utilisateur */
        $ti_article = ArticleCampagne::getObjectsByIdCampagne($i_idCampagne);
        /* Pour chaque article on modifie la quantité si nécéssaire */
        foreach($ti_article as &$i_article) {
            $i_idArticle = $i_article['id_article'];
            echo 'idArticle';
            echo $i_idArticle;
            /* vérifier si l'article est bien dans le rayon */
            $i_idRayonArticle = Article::getIdRayon($i_idArticle);
            if($i_idRayon == $i_idRayonArticle) {
                /* Si des modifications ont été faite par l'utilisateur, on traite l'entrée */
                if (isset($_POST['quantite'])){
                    $ti_quantite = $_POST['quantite'];
                    echo 'avant quantite';
                    $i_quantite = $ti_quantite[$i_idArticle];
                    echo $i_quantite;
                    if($i_quantite != 0) {
                        /* Vérifie si l'article dont la quantité a été modifié est déjà présent dans la commande 
                         * sinon crée la commande */
                        $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                        if ($i_idCommande == 0) {
                            Commande::create($i_idArticle, $i_idCampagne, $i_idUtilisateur, 0);
                        }
                        $i_seuilMin = ArticleCampagne::getSeuilMinByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                        /* Si la quantité est supérieur au seuil min et non nulle, on 
                         * actualise, sinon on ne fait rien */
                        if ($i_quantite >= $i_seuilMin) {
                            $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                            Commande::setQuantite($i_idCommande, $i_quantite);
                        }
                    }	
                }
            }
        }
        echo $i_idRayon;
        /* Redirection */
        header('Location: '.root.'/commanderArticle.php/commanderArticle?idRayon='.$i_idRayon);
    }

    /*
     * Supprime l'article de l'utilisateur courant.
     */
    public function commanderArticleSupprimer() {
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = Campagne::getIdCampagneCourante();
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        if (!isset($_GET['idRayon'])) {	
            $this->render('afficherRayon');
            return;
        }
        $i_idRayon = $_GET['idRayon'];
        /* La campagne est fermée */
        if ($b_etat == 0) {
            header('Location: '.root.'/commanderArticle.php/commanderArticle?idRayon='.$i_idRayon);
            return;
        }
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur = $_SESSION['idUtilisateur'];
        /* Récupération de l'id article à supprimer */
        $i_idArticle = $_GET['id_article'];
        $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
        Commande::delete($i_idCommande);
        /* Redirection */
        header('Location: '.root.'/commanderArticle.php/commanderArticle?idRayon='.$i_idRayon);
    }

    /*
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/commanderArticle.php/commanderArticle');
    }
}
new CommanderArticleController();
?>
