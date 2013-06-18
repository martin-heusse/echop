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
class UtilisateurAyantCommandEController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche la liste de tous les utilisateurs ayant effectué une commande 
     * dans la campagne courante.
     */
    public function utilisateurAyantCommandE(){  
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
        $to_commande = Commande::getIdUtilisateurUniqueByIdCampagne($i_idCampagne);
        foreach($to_commande as &$o_article) {
            $i_idUtilisateur = $o_article['id_utilisateur'];
            echo "id=".$i_idUtilisateur."<br/>";
            $o_article['login_utilisateur'] = Utilisateur::getLogin($i_idUtilisateur);
            $to_article = Commande::getIdArticleByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);
            /* A été livré ou non */
            $o_article['tout_livre'] = 0;
            if ($d = Commande::getCountByEstLivreForIdCampagneIdUtilisateur(0, $i_idCampagne, $i_idUtilisateur) == 0) {
                $o_article['tout_livre'] = 1;
            }
            var_dump($d);

            /* Montant total */
            $o_article['montant_total'] = 0;
            
            foreach($to_article as $o_produit){
                $i_idArticle = $o_produit['id_article'];
                $i_quantite = Commande::getQuantiteByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                $i_poidsPaquetClient = ArticleCampagne::getPoidsPaquetClient($i_idArticleCampagne);
                $i_prixTtc = ArticleCampagne::getPrixTtc($i_idArticleCampagne);                
                $i_idPoidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
            /* Calcul quantité totale */
            $i_quantiteTotale = $i_quantite * $i_poidsPaquetClient;
            /* Calcul total TTC */
            $i_totalTtc = $i_quantiteTotale * $i_prixTtc / $i_idPoidsPaquetFournisseur;
            /* Calcul du montant total */
            $o_article['montant_total'] += $i_totalTtc;
            } 
            /* Formattage des nombres */
            $i_quantiteTotale = number_format($i_quantiteTotale, 2, '.', '');
            $i_totalTtc = number_format($i_totalTtc, 2, '.', '');
            $o_article['montant_total'] = number_format($o_article['montant_total'], 2, '.', '');
        } 
        /* Render */
        $this->render('utilisateurAyantCommandE', compact('to_commande', 'b_historique', 'i_idCampagne'));	
    }

    /*
     * Affiche la liste des commandes d'un utilisateur pour la campagne 
     * courante.
     */
    public function commandeUtilisateur() {
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
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* Récupération des articles commandés par l'utilisateur */
        if (!isset($_GET['idUtilisateur'])) {
            header('Location: '.root.'/utilisateurAyantCommandE.php/utilisateurAyantCommandE');
            return;
        }
        $i_idUtilisateur = $_GET['idUtilisateur'];
        $to_commande = Commande::getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);
        /* Montant total */
        $f_montantTotal = 0;
        /* Récupération de tous les attributs nécessaires d'un article */
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
            /* Calcul du montant total */
            $f_montantTotal += (float) $o_article['total_ttc'];
            /* Formattage des nombres */
            $o_article['prix_unitaire'] = number_format($o_article['prix_unitaire'], 2, '.', '');
            $o_article['quantite_totale'] = number_format($o_article['quantite_totale'], 2, '.', '');
            $o_article['total_ttc'] = number_format($o_article['total_ttc'], 2, '.', '');
        }
        // recherche du login 
        $s_login = Utilisateur::getLogin($i_idUtilisateur);
        /* Formattage des nombres */
        $f_montantTotal = number_format($f_montantTotal, 2, '.', '');
        /* Render */
        $this->render('commandeUtilisateur', compact('to_commande', 'b_etat', 'f_montantTotal', 'i_idUtilisateur', 's_login', 'b_historique', 'i_idCampagne'));	
    }

    /*
     * Gère la modification des quantités dans la commande d'un utilisateur.
     */
    public function modifierQuantiteUtilisateur() {
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
        /* Récupération des articles commandés par l'utilisateur */
        if (!isset($_GET['idUtilisateur'])) {
            header('Location: '.root.'/utilisateurAyantCommandE.php/utilisateurAyantCommandE');
            return;
        }
        $i_idUtilisateur = $_GET['idUtilisateur']; 
        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
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
            /* Modification de est_livre */
            if (isset($_POST['est_livre'])) {
                $tb_estLivre = $_POST['est_livre'];
                $b_estLivre = $tb_estLivre[$i_idArticle];
                if ($b_estLivre == 1) {
                    Commande::setEstLivre($i_idCommande, 1);
                } else {
                    Commande::setEstLivre($i_idCommande, 0);
                }
            }
        }
        /* Redirection */
        if ($i_idCampagne == Campagne::getIdCampagneCourante()) {
            header('Location: '.root.'/utilisateurAyantCommandE.php/commandeUtilisateur?idUtilisateur='.$i_idUtilisateur);
        } else {
            header('Location: '.root.'/utilisateurAyantCommandE.php/commandeUtilisateur?idUtilisateur='.$i_idUtilisateur.'&idOldCampagne='.$i_idCampagne);
        }
    }

    /*
     * Supprime l'article d'un utilisateur.
     */
    public function supprimerArticleUtilisateur() {
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
        /* Récupération des articles commandés par l'utilisateur */
        if (!isset($_GET['idUtilisateur'])) {
            header('Location: '.root.'/utilisateurAyantCommandE.php/utilisateurAyantCommandE');
        }
        $i_idUtilisateur = $_GET['idUtilisateur']; 
        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* Récupération de l'id article à supprimer */
        $i_idArticle = $_GET['id_article'];
        $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
        Commande::delete($i_idCommande);
        /* Redirection */
        if ($i_idCampagne == Campagne::getIdCampagneCourante()) {
            header('Location: '.root.'/utilisateurAyantCommandE.php/commandeUtilisateur?idUtilisateur='.$i_idUtilisateur);
        } else {
            header('Location: '.root.'/utilisateurAyantCommandE.php/commandeUtilisateur?idUtilisateur='.$i_idUtilisateur.'&idOldCampagne='.$i_idCampagne);
        }
    }

    /*
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/utilisateurAyantCommandE.php/mesCommandes');
    }
}
new UtilisateurAyantCommandEController();
?>
