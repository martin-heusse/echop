<?php

require_once('def.php');
require_once('Util.php');
require_once('Model/Export.php');
require_once('Model/Commande.php');
require_once('Model/Campagne.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Article.php');
require_once('Model/Unite.php');
require_once('Model/Categorie.php');
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

    function calcManque($quantiteTotale, $poidsPaquetClient, $colisage) {
        $frac_manque = round((float) $quantiteTotale / (float) $poidsPaquetClient) % round((float) $colisage / (float) $poidsPaquetClient);
        if ($frac_manque > 0) {
            $manque = $colisage - $frac_manque * $poidsPaquetClient;
        } else {
            $manque = 0;
        };
        return $manque;
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
        /* On vérifie qu'on a bien un article à modifier et on récupère son 
         * identifiant si c'est le cas */
        if (!isset($_GET['idArticle'])) {
            header('Location: ' . root . '/articlesCommandEs.php/utilisateurAyantCommandE');
            return;
        }
        $i_idArticle = $_GET['idArticle'];
        /* On récupère l'identifiant de l'utilisateur qui a passé la commande */
        if (!isset($_GET['idUtilisateur'])) {
            header('Location: ' . root . '/articlesCommandEs.php/utilisateurAyantCommandE');
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
        /* Modification de l'article :
          /* Si des quantités ont été modifiées, on traite l'entrée */
        if (isset($_POST['quantite'])) {
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
            header('Location: ' . root . '/articlesCommandEs.php/commandeUtilisateurPourCetArticle?idUtilisateur=' . $i_idUtilisateur . '&idArticle=' . $i_idArticle);
        } else {
            header('Location: ' . root . '/articlesCommandEs.php/commandeUtilisateurPourCetArticle?idUtilisateur=' . $i_idUtilisateur . '&idArticle=' . $i_idArticle . '&idOldCampagne=' . $i_idCampagne);
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
        /* Récupération de l'identifiant de article à supprimer */
        if (!isset($_GET['idArticle'])) {
            return;
        }
        $i_idArticle = $_GET['idArticle'];
        /* Récupération de l'identifiant de l'utilisateur qui a passé la 
         * commande */
        if (!isset($_GET['idUtilisateur'])) {
            header('Location: ' . root . '/articlesCommandEs.php/utilisateurAyantCommandE');
            return;
        } else {
            $i_idUtilisateur = $_GET['idUtilisateur'];
        }

        /* Navigation dans l'historique ou non */
        /* $b_historique = 0; */
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            /*  $b_historique = 1; */
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        /* Récupération de l'état de la campagne */
        /* $b_etat = Campagne::getEtat($i_idCampagne); */
        /* On supprime l'article de la commande de l'utilisateur donné */
        $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
        Commande::delete($i_idCommande);
        /* Redirection */
        if ($i_idCampagne == Campagne::getIdCampagneCourante()) {
            header('Location: ' . root . '/articlesCommandEs.php/utilisateursAyantCommandECetArticle?idArticle=' . $i_idArticle);
        } else {
            header('Location: ' . root . '/articlesCommandEs.php/utilisateursAyantCommandECetArticle?idArticle=' . $i_idArticle . '&idOldCampagne=' . $i_idCampagne);
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

        $s_login = $_SESSION['login'];
        $o_profil = Utilisateur::getObjectByLogin($s_login);
        $i_id = $o_profil['id'];


        /* On récupère tous les articles que l'on peut commander lors d'une 
         * campagne */
        $to_article = Commande::getIdArticleByIdCampagne($i_idCampagne);
        /* On récupère les attributs nécéssaires pour chaque article */
        foreach ($to_article as &$o_row) {
            $o_row['nom'] = Article::getNom($o_row['id_article']);
            $i_idArticle = $o_row['id_article'];
            $o_row['quantite_totale'] = 0;
            $o_row['quantite_totale_unites'] = 0;
            $i_idUnite = Article::getIdUnite($i_idArticle);
            $o_row['unite'] = Unite::getUnite($i_idUnite);
            $to_commande = Commande::getObjectsByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_poidsPaquetClient = ArticleCampagne::getPoidsPaquetClient($i_idArticleCampagne);
            $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
            $i_nbrePaquetColis = Article::getNbPaquetColis($i_idArticle);
            $o_row['colisage'] = $i_poidsPaquetFournisseur * $i_nbrePaquetColis;
            $o_row['commandeParUtilsateurCourant'] = 0;
            /* on récupère la quantité totale commandée par le produit */
            foreach ($to_commande as $o_commande) {
                if ($o_commande['id_utilisateur'] == $i_id) {
//                     echo $i_idUtilisateur."  " ; echo $o_row['quantite_totale'];
                    // Quantité en nombre d'unités-client
                    $o_row['commandeParUtilsateurCourant'] = $o_commande['quantite'];
                }
                $i_quantite = $o_commande['quantite'] * $i_poidsPaquetClient;
                $o_row['quantite_totale_unites'] += $o_commande['quantite'];
                $o_commande['quantite'] = $i_quantite;
                $o_row['quantite_totale'] += $i_quantite;
            }
            /* calcul pour le colisage */

            $o_row['manque'] = $this->calcManque($o_row['quantite_totale'], $i_poidsPaquetClient, $o_row['colisage']);
            $o_row['manque_unite'] = $o_row['manque'] / $i_poidsPaquetClient;
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
        /* On récupère l'identifiant de l'article */
        if (!isset($_GET['idArticle'])) {
            header('Location: ' . root . '/articlesCommandEs.php/articlesCommandEs');
            return;
        }
        $i_idArticle = $_GET['idArticle'];
        /* On récupère les commandes-utilisateurs qui contiennent ce produit */
        $to_utilisateur = Commande::getObjectsByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
        $i_idUnite = Article::getIdUnite($i_idArticle);
        $s_unite = Unite::getUnite($i_idUnite);
        $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
        $i_poidsPaquetClient = ArticleCampagne::getPoidsPaquetClient($i_idArticleCampagne);
        $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
        $i_nbrePaquetColis = Article::getNbPaquetColis($i_idArticle);
        $i_colisage = $i_poidsPaquetFournisseur * $i_nbrePaquetColis;
        $i_quantiteTotale = 0;
        /* On récupère tous les utilisateurs qui ont commandé cet article */
        foreach ($to_utilisateur as &$o_row) {
            $o_row['login'] = Utilisateur::getLogin($o_row['id_utilisateur']);
            $o_row['id'] = $o_row['id_utilisateur'];
            $i_idUtilisateur = $o_row['id'];
            $i_quantite = Commande::getQuantiteByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
            $o_row['quantite'] = $i_quantite * $i_poidsPaquetClient;
            $i_quantiteTotale += $o_row['quantite'];
        }
        /* calcul du colisage */
        $i_manque = $this->calcManque($i_quantiteTotale, $i_poidsPaquetClient, $i_colisage);

        /* Liste des utilisateurs n'ayant _pas_ commandé (pour leur forcer la main) */
        $not_utilisateur = Commande::getObjectsNotOrderedByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
        /* Préparation rendering */
        $s_nomArticle = Article::getNom($i_idArticle);
        /* sécurité */
        $i_idArticle = htmlentities($_GET['idArticle'], null, 'UTF-8');
        $this->render('utilisateursAyantCommandECetArticle', compact('i_idArticle', 'to_utilisateur', 'not_utilisateur', 'i_colisage', 's_nomArticle', 'i_quantiteTotale', 's_unite', 'i_poidsPaquetClient', 'i_manque', 'b_historique', 'i_idCampagne'));
    }

    public function forceUtilisateur() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* On vérifie qu'on a bien un article à modifier et on récupère son 
         * identifiant si c'est le cas */
        if ($_SESSION['isAdministrateur']) {
            /* Côté administrateur (paf!) */
            if (!isset($_GET['idArticle'])) {
                header('Location: ' . root . '/articlesCommandEs.php/utilisateurAyantCommandE');
                return;
            }
            $i_idArticle = htmlentities($_GET['idArticle'], null, 'UTF-8');
        } else {
            /* Colisage de l'utilisateur */
            $i_nbArticle = count(Article::getAllObjects());
            for ($i_nbArticle = 0; $i_nbArticle < 100; $i_nbArticle++) {
                /* On récupère l'id de l'article choisi */
                if (isset($_POST['idArticle_' . $i_nbArticle])) {
                    $i_idArticle = $i_nbArticle;
                    break;
                }
            }
        }
        /* Permet de recalculer le manque et donc de gérer les transactions */
        /* On récupère les commandes-utilisateurs qui contiennent ce produit */
        $i_idCampagne = Campagne::getIdCampagneCourante();
        $to_utilisateur = Commande::getObjectsByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
        $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
        $i_poidsPaquetClient = ArticleCampagne::getPoidsPaquetClient($i_idArticleCampagne);
        $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
        $i_nbrePaquetColis = Article::getNbPaquetColis($i_idArticle);
        $i_colisage = $i_poidsPaquetFournisseur * $i_nbrePaquetColis;
        $i_quantiteTotale = 0;
        /* On récupère tous les utilisateurs qui ont commandé cet article */
        foreach ($to_utilisateur as &$o_row) {            
            $i_idUtilisateur = $o_row['id_utilisateur'];
            $i_quantite = Commande::getQuantiteByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
            $o_row['quantite'] = $i_quantite * $i_poidsPaquetClient;
            $i_quantiteTotale += $o_row['quantite'];
        }
        $i_manque = $this->calcManque($i_quantiteTotale, $i_poidsPaquetClient, $i_colisage);
        if ($i_manque > 0) {
            /* Navigation dans l'historique ou non */
            $b_historique = 0;
            if (isset($_GET['idCampagne'])) {
                $i_idCampagne = $_GET['idCampagne'];
                $b_historique = 1;
            } else {
                $i_idCampagne = Campagne::getIdCampagneCourante();
            }
            /* Un select par ligne, donc une nom de variable dédié pour chaque ligne */
            if (isset($_POST['forceQuantite_' . $i_nbArticle])) {
                $f_quantite = $_POST['forceQuantite_' . $i_nbArticle];
                if ($f_quantite > 0) {
                    $f_utilisateur = $_POST['forceUtilisateur'];
                    /* Quand tous les paramètres ont été récupérés, on vérifie si une commande 
                     * pour le même utilisateur, le même article n'a pas déjà été fait lors de cette campagne
                     */
                    $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $f_utilisateur);

                    /* Si c'est le cas, on ajoute la quantité à la précédente commande */
                    if ($i_idCommande != NULL) {
                        Commande::setAjoutQuantite($i_idCommande, $f_quantite);
                    }
                    /* Sinon on en crée une nouvelle */ else {
                        Commande::create($i_idArticle, $i_idCampagne, $f_utilisateur, $f_quantite);
                    }
                }
            }
        }


        /* Redirection */
        if ($_SESSION['isAdministrateur']) {
            if ($i_idCampagne == Campagne::getIdCampagneCourante()) {
                header('Location: ' . root . '/articlesCommandEs.php/utilisateursAyantCommandECetArticle?idArticle=' . $i_idArticle);
            } else {
                header('Location: ' . root . '/articlesCommandEs.php/utilisateursAyantCommandECetArticle?idArticle=' . $i_idArticle . '&idOldCampagne=' . $i_idCampagne);
            }
        } else {
            header('Location: ' . root . '/articlesCommandEs.php/articlesCommandEs');
        }
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
        /* récupération de l'article */
        if (!isset($_GET['idArticle'])) {
            return;
        }
        $i_idArticle = $_GET['idArticle'];
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
        /* Récupération de l'utilisateur */
        if (!isset($_GET['idUtilisateur'])) {
            header('Location: ' . root . '/articlesCommandEs.php/utilisateurAyantCommandE');
            return;
        }
        $i_idUtilisateur = $_GET['idUtilisateur'];
        /* récupération de l'article commandé par l'utilisateur */
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
        /* Calcul quantité totale */
        $o_commande['quantite_totale'] = $o_commande['quantite'] * $o_commande['poids_paquet_client'];
        /* Calcul total TTC */
        $o_commande['total_ttc'] = $o_commande['quantite_totale'] * $o_commande['prix_ttc'] / $o_commande['poids_paquet_fournisseur'];
        // recherche du login 
        $s_login = Utilisateur::getLogin($i_idUtilisateur);
        /* Formattage des nombres */
        $o_commande['prix_unitaire'] = number_format($o_commande['prix_unitaire'], 2, '.', '');
        $o_commande['quantite_totale'] = number_format($o_commande['quantite_totale'], 2, '.', '');
        $o_commande['total_ttc'] = number_format($o_commande['total_ttc'], 2, '.', '');
        /* Render */
        $this->render('commandeUtilisateurPourCetArticle', compact('i_idArticle', 'o_commande', 'b_etat', 'i_idUtilisateur', 's_login', 'b_historique', 'i_idCampagne'));
    }

     public function exportCSV() {
         
        /*
         * Cette méthode va être écrite de manière différente des autres exports csv.
         * Comme il y a pas mal de calcul, cette méthode ne se base pas sur des requêtes,
         * mais bien sur les calculs sous php. Notamment le calcul du colisage qui appelle une fonction.
         * L'écriture se fait "manuellement" grâce à des méthodes implémentées dans Export.php et qui pourront être réutilisables.
         */ 
         
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
        
        /* Récupération de l'Id campagne courante */
        $i_idCampagne = Campagne::getIdCampagneCourante();
        
        // Nom BD
        $database="BdEchoppe";
        
        // Connexion BD
        Export::connect();

        // la variable qui va contenir les données CSV
        $outputCsv = '';
        
        // Nom du fichier qu'on initialise puis qu'on attribue
        $fileName = "Export_Article_Commandes_Campagne".$i_idCampagne."_".date('d/m/Y').".csv";

        // Titre des colonnes 
        $outputCsv=  Export::excelWrite($outputCsv, "Article");
        $outputCsv=  Export::excelWrite($outputCsv, "Quantite totale commandee");
        $outputCsv=  Export::excelWrite($outputCsv, "Colisage");
        $outputCsv=  Export::excelWrite($outputCsv, "Manque");
        
        // On enlève le ; parasite 
        $outputCsv=  Export::excelDeletePoint($outputCsv);
        
        // On passe à la ligne avant remplissage des tables
        $outputCsv=  Export::excelJump($outputCsv);
        
        /* On récupère tous les articles que l'on peut commander lors d'une 
         * campagne */
        $to_article = Commande::getIdArticleByIdCampagne($i_idCampagne);
        
        /* On récupère les attributs nécéssaires pour chaque article */
        foreach ($to_article as &$o_row) {
            $o_row['nom'] = Article::getNom($o_row['id_article']);
            $i_idArticle = $o_row['id_article'];
            $o_row['quantite_totale'] = 0;
            $o_row['quantite_totale_unites'] = 0;
            $i_idUnite = Article::getIdUnite($i_idArticle);
            $o_row['unite'] = Unite::getUnite($i_idUnite);
            $to_commande = Commande::getObjectsByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_poidsPaquetClient = ArticleCampagne::getPoidsPaquetClient($i_idArticleCampagne);
            $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
            $i_nbrePaquetColis = Article::getNbPaquetColis($i_idArticle);
            $o_row['colisage'] = $i_poidsPaquetFournisseur * $i_nbrePaquetColis;
            /* on récupère la quantité totale commandée par le produit */
            foreach ($to_commande as $o_commande) {
                $i_quantite = $o_commande['quantite'] * $i_poidsPaquetClient;
                $o_row['quantite_totale_unites'] += $o_commande['quantite'];
                $o_commande['quantite'] = $i_quantite;
                $o_row['quantite_totale'] += $i_quantite;
            }
            /* Calcul pour le colisage */

            $o_row['manque'] = $this->calcManque($o_row['quantite_totale'], $i_poidsPaquetClient, $o_row['colisage']);
            $o_row['manque_unite'] = $o_row['manque'] / $i_poidsPaquetClient;
            
            /*Une fois les infos récupérés pour un produit, on écrit dans l'excel*/
            $outputCsv=  Export::excelWrite($outputCsv, $o_row['nom']);
            $outputCsv=  Export::excelWrite($outputCsv, $o_row['quantite_totale'].$o_row['unite']. " (".$o_row['quantite_totale_unites']." unites)");
            $outputCsv=  Export::excelWrite($outputCsv, "Multiple de ".$o_row['colisage'].$o_row['unite']);
            $outputCsv=  Export::excelWrite($outputCsv, $o_row['manque_unite']." unite(s)"." (".$o_row['manque'].$o_row['unite'].")");
            
            /*On supprime le ; en trop*/
            $outputCsv= Export::excelDeletePoint($outputCsv);
            
            /* On saute une ligne */
            $outputCsv= Export::excelJump($outputCsv);
        
        }
        //Formatage du fichier
        Util::headerExcel($fileName);        
        
        /* On sort*/
        echo $outputCsv;
        exit();
    }
    
    /*
     * Action par défaut.
     */

    public function defaultAction() {
        header('Location: ' . root . '/articlesCommandEs.php/mesCommandes');
    }

}

new ArticlesCommandEsController();
?>
