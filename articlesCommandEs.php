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
class ArticlesCommandEsController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
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
        if (!isset($_GET['idArticle'])) {
            return;
        }
        $i_idArticle = $_GET['idArticle'];
        /* Récupération des articles commandés par l'utilisateur */
        if (!isset($_GET['idUtilisateur'])) {
            header('Location: '.root.'/articlesCommandEs.php/utilisateurAyantCommandE');
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
        /* Modification de l'article */
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
        /* Redirection */
        if ($i_idCampagne == Campagne::getIdCampagneCourante()) {
            header('Location: '.root.'/articlesCommandEs.php/commandeUtilisateurPourCetArticle?idUtilisateur='.$i_idUtilisateur.'&idArticle='.$i_idArticle);
        } else {
            header('Location: '.root.'/articlesCommandEs.php/commandeUtilisateurPourCetArticle?idUtilisateur='.$i_idUtilisateur.'&idArticle='.$i_idArticle.'&idOldCampagne='.$i_idCampagne);
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
        if (!isset($_GET['idArticle'])) {
            return;
        }
        /* Récupération de l'id article à supprimer */
        $i_idArticle = $_GET['idArticle'];
        /* Récupération des articles commandés par l'utilisateur */
        if (!isset($_GET['idUtilisateur'])) {
            header('Location: '.root.'/articlesCommandEs.php/utilisateurAyantCommandE');
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
        $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
        Commande::delete($i_idCommande);
        /* Redirection */
        if ($i_idCampagne == Campagne::getIdCampagneCourante()) {
            header('Location: '.root.'/articlesCommandEs.php/utilisateursAyantCommandECetArticle?idArticle='.$i_idArticle);
        } else {
            header('Location: '.root.'/articlesCommandEs.php/utilisateursAyantCommandECetArticle?idArticle='.$i_idArticle.'&idOldCampagne='.$i_idCampagne);
        }
    }

    /*
     * Affiche la liste des articles commandés pour la campagne courante.
     */
    public function articlesCommandEs() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
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
        $to_article = Commande::getIdArticleByIdCampagne($i_idCampagne);
        foreach ($to_article as &$o_row) {
            $o_row['nom'] = Article::getNom($o_row['id_article']);
            $i_idArticle = $o_row['id_article'];
            $o_row['quantite_totale'] = 0;
            $i_idUnite = Article::getIdUnite($i_idArticle); 
            $o_row['unite'] = Unite::getUnite($i_idUnite);
            $to_commande = Commande::getObjectsByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_poidsPaquetClient = ArticleCampagne::getPoidsPaquetClient($i_idArticleCampagne);
            $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
            $i_nbrePaquetColis = Article::getNbPaquetColis($i_idArticle);
            $o_row['colisage'] = $i_poidsPaquetFournisseur * $i_nbrePaquetColis;
            foreach ($to_commande as $o_commande) {
                $i_quantite = $o_commande['quantite']*$i_poidsPaquetClient;
                $o_commande['quantite'] = $i_quantite;
                $o_row['quantite_totale'] += $i_quantite;
            }
    
        $f_float = $o_row['quantite_totale']-floor($o_row['quantite_totale']);
            $i_manque = $o_row['quantite_totale'] % $o_row['colisage'];
            $o_row['manque'] = ($o_row['colisage'] - $i_manque) % $o_row['colisage'];
            if($o_row['manque']-$f_float < 0){
                $o_row['manque'] += $o_row['colisage'] - $f_float;
            } else {
                $o_row['manque'] += -$f_float;
            }

        }
        $this->render('articlesCommandEs', compact('to_article', 'b_historique', 'i_idCampagne'));	
    }

    /*
     * Affiche les utilisateurs ayant commandé un article en particulier pour la 
     * campagne courante.
     */
    public function utilisateursAyantCommandECetArticle() {
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
        /* Paramètre GET nécessaire */
        if(!isset($_GET['idArticle'])) {
            header('Location: '.root.'/articlesCommandEs.php/articlesCommandEs');
            return;
        }
        $i_idArticle = $_GET['idArticle'];
        $to_utilisateur = Commande::getObjectsByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
        $i_idUnite = Article::getIdUnite($i_idArticle); 
        $s_unite = Unite::getUnite($i_idUnite);
        $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
        $i_poidsPaquetClient = ArticleCampagne::getPoidsPaquetClient($i_idArticleCampagne);
        $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
        $i_nbrePaquetColis = Article::getNbPaquetColis($i_idArticle);
        $i_colisage = $i_poidsPaquetFournisseur * $i_nbrePaquetColis;
        $i_quantiteTotale = 0;
        foreach ($to_utilisateur as &$o_row) {
            $o_row['login'] = Utilisateur::getLogin($o_row['id_utilisateur']);
            $o_row['id'] = $o_row['id_utilisateur'];
            $i_idUtilisateur = $o_row['id'];
            $i_quantite = Commande::getQuantiteByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
            $o_row['quantite'] = $i_quantite * $i_poidsPaquetClient;
            $i_quantiteTotale += $o_row['quantite'];

        }
        $f_float = $i_quantiteTotale-floor($i_quantiteTotale);
        $i_manque = $i_quantiteTotale % $i_colisage;
        $i_manque = ($i_colisage - $i_manque) % $i_colisage;
            if($i_manque-$f_float < 0){
                $i_manque += $i_colisage - $f_float;
            } else {
                $i_manque += -$f_float;
            }
        $s_nomArticle = Article::getNom($i_idArticle);
        $i_idArticle = htmlentities($_GET['idArticle']);
        $this->render('utilisateursAyantCommandECetArticle', compact('i_idArticle', 'to_utilisateur', 'i_colisage', 's_nomArticle', 'i_quantiteTotale', 's_unite', 'i_manque', 'b_historique', 'i_idCampagne'));
    }

    /*
     * Affiche l'article à modifier d'un utilisateur pour la campagne courante.
     */
    public function commandeUtilisateurPourCetArticle() {
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
        if (!isset($_GET['idArticle'])) {
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
            header('Location: '.root.'/articlesCommandEs.php/utilisateurAyantCommandE');
            return;
        }
        $i_idUtilisateur = $_GET['idUtilisateur'];
        $i_idArticle = $_GET['idArticle'];
        $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
        $o_commande = Commande::getObject($i_idCommande);
        /* Récupération de tous les attributs nécessaires d'un article */
        /* Attributs dépendant de l'article */
        $i_idArticle = $o_commande['id_article'];
        $o_commande['nom'] = Article::getNom($i_idArticle);
        $o_commande['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
        $i_idUnite = Article::getIdUnite($i_idArticle);
        $o_commande['unite'] = Unite::getUnite($i_idUnite);
        $o_commande['nb_paquet_colis'] = Article::getNbPaquetColis($i_idArticle);
        $o_commande['description_courte'] = Article::getDescriptionCourte($i_idArticle);
        $o_commande['description_longue'] = Article::getDescriptionLongue($i_idArticle);
        /* Prix TTC, seuil min et poids paquet client */
        $o_commande_campagne = ArticleCampagne::getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
        $o_commande['prix_ttc'] = $o_commande_campagne['prix_ttc'];
        $o_commande['seuil_min'] = $o_commande_campagne['seuil_min'];
        $o_commande['poids_paquet_client'] = $o_commande_campagne['poids_paquet_client'];

        /* Valeurs calculées */
        /* Calcul poids unitaire */
        $o_commande['prix_unitaire'] = $o_commande['prix_ttc'] / $o_commande['poids_paquet_fournisseur'];
        $o_commande['prix_unitaire'] = number_format($o_commande['prix_unitaire'], 2, '.', ' ');
        /* Calcul quantité totale */
        $o_commande['quantite_totale'] = $o_commande['quantite'] * $o_commande['poids_paquet_client'];
        $o_commande['quantite_totale'] = number_format($o_commande['quantite_totale'], 2, '.', ' ');
        /* Calcul total TTC */
        $o_commande['total_ttc'] = $o_commande['quantite_totale'] * $o_commande['prix_ttc'] / $o_commande['poids_paquet_fournisseur'];
        $o_commande['total_ttc'] = number_format($o_commande['total_ttc'], 2, '.', ' ');
        // recherche du login 
        $s_login = Utilisateur::getLogin($i_idUtilisateur);
        $this->render('commandeUtilisateurPourCetArticle', compact('i_idArticle', 'o_commande', 'b_etat', 'i_idUtilisateur', 's_login', 'b_historique', 'i_idCampagne'));
    }

    /*
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/articlesCommandEs.php/mesCommandes');
    }
}
new ArticlesCommandEsController();
?>
