<?php

require_once('def.php');
require_once('Model/Campagne.php');
require_once('Model/Commande.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Article.php');
require_once('Model/Unite.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/ArticleFournisseur.php');
require_once('Model/Rayon.php');
require_once('Model/Fournisseur.php');
require_once('Util.php');

/*
 * Gère les campagnes.
 */

class CampagneController extends Controller {
    /*
     * Constructeur.
     */

    public function __construct() {
        parent::__construct();
    }

    /*
     * Permet d'ouvrir, de fermer ou de changer de campagne courante.
     */

    public function gererCampagne() {
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
        /* Ouvrir ou fermer la campagne courante */
        if (isset($_GET['etat'])) {
            $b_etat = $_GET['etat'];
            $i_idCampagneCourante = Campagne::getIdCampagneCourante();
            if ($b_etat == 1) {
                Campagne::setEtat($i_idCampagneCourante, 1);
            } else if ($b_etat == 0) {
                Campagne::setEtat($i_idCampagneCourante, 0);
            }
        }
        /* Affiche la page de gestion de la campagne courante */
        $o_campagne = Campagne::getCampagneCourante();
        /* Affiche les campagnes précédentes */
        $to_oldCampagne = Campagne::getAllAncienneCampagne();
        $this->render('gererCampagne', compact('o_campagne', 'to_oldCampagne'));
    }

    /*
     * Archive la campagne courante et en ouvre une nouvelle.
     */

    public function nouvelleCampagne() {
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
        $i_idCampagneCourante = Campagne::getIdCampagneCourante();
        $b_etat = Campagne::getEtat($i_idCampagneCourante);
        /* La campagne courante doit être fermée */
        if ($b_etat == 1) {
            header('Location: ' . root . '/campagne.php/gererCampagne');
            return;
        }
        /* Désaffecte la campagne courante */
        Campagne::setCourant($i_idCampagneCourante, 0);

        /* Récupération des données pour la réaffection */
        $i_idOldCampagne = $i_idCampagneCourante;
        $to_article = ArticleCampagne::getObjectsByIdCampagne($i_idOldCampagne);

        /* Crée la nouvelle campagne */
        date_default_timezone_set("Europe/Paris");
        $s_dateDebut = date("Y-m-d", time());
        $b_etat = 1;
        $b_courant = 1;
        $i_idCampagneCourante = Campagne::create($s_dateDebut, $b_etat, $b_courant);


        /* Réaffection des articles de la campagne précédente  */
        foreach ($to_article as $o_article) {
            $i_idArticle = $o_article['id_article'];
            $i_idFournisseur = $o_article['id_fournisseur'];
            $i_idTva = $o_article['id_tva'];
            $f_poidsPaquetClient = $o_article['poids_paquet_client'];
            $i_seuilMin = $o_article['seuil_min'];
            $f_prixTtc = $o_article['prix_ttc'];
            $b_enVente = 0;
            ArticleCampagne::create($i_idArticle, $i_idCampagneCourante, $i_idFournisseur, $i_idTva, $f_poidsPaquetClient, $i_seuilMin, $f_prixTtc, $b_enVente);
        }
        /* Réaffecte le prix des articles des fournisseurs */
        $ti_idOldArticleCampagne = ArticleCampagne::getIdByIdCampagne($i_idOldCampagne);
        foreach ($ti_idOldArticleCampagne as $i_idOldArticleCampagne) {
            $to_fournisseur = ArticleFournisseur::getObjectsByIdArticleCampagne($i_idOldArticleCampagne);
            foreach ($to_fournisseur as $o_fournisseur) {
                /* Atribut de ArticleFournisseur */
                $i_idFournisseur = $o_fournisseur['id_fournisseur'];
                $f_prixHt = $o_fournisseur['prix_ht'];
                $f_prixTtc = $o_fournisseur['prix_ttc'];
                $s_code = $o_fournisseur['code'];
                $b_prixTtcHt = $o_fournisseur['prix_ttc_ht'];
                $b_ventePaquetUnite = $o_fournisseur['vente_paquet_unite'];
                /* Récupération de l'idArticle précédemment créé */
                $i_idArticle = ArticleCampagne::getIdArticle($i_idOldArticleCampagne);
                $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagneCourante);
                /* Création */
                ArticleFournisseur::create($i_idArticleCampagne, $i_idFournisseur, $f_prixHt, $f_prixTtc, $s_code, $b_prixTtcHt, $b_ventePaquetUnite);
            }
        }
        header('Location: ' . root . '/campagne.php/gererCampagne');
    }

    /*
     * Avertir les utilisateurs du lancement de la nouvelle campagne par mail.
     */

    public function avertirUtilisateurNouvelleCampagne() {
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

        /* envoi d'un mail à tous les utilisateurs */
        $to_utilisateur = Utilisateur::getAllObjects();
        $s_subject = "[L'Échoppe d'ici et d'ailleurs] Campagne ouverte";
        $s_message = "Une campagne vient d'être ouverte, venez sur le site pour effectuer vos achats.";
        foreach ($to_utilisateur as $o_utilisateur) {
            $o_utilisateur['desinscrit'] = Utilisateur::getDesinscrit($o_utilisateur['id']);
            if ($o_utilisateur['validite'] == 1 and $o_utilisateur['desinscrit'] == 0) {
                $s_destinataire = $o_utilisateur['email'];
                Util::sendEmail($s_destinataire, $s_subject, $s_message);
            }

            header('Location: ' . root . '/campagne.php/gererCampagne');
        }
    }

    /*
     * Affiche l'historique des campagnes passées.
     */

    public function historiqueCampagne() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        /* if(!$_SESSION['isAdministrateur']) {
          $this->render('adminRequired');
          return;
          } */
        $to_campagne = Campagne::getObjectsByCourant(0);
        $this->render('historiqueCampagne', compact('to_campagne'));
    }

    public function dnd() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        /* if(!$_SESSION['isAdministrateur']) {
          $this->render('adminRequired');
          return;
          } */
        $to_campagne = Campagne::getObjectsByCourant(0);
        $this->render('dnd', compact('to_campagne'));
    }

    /*
     * Action par défaut.
     */

    public function defaultAction() {
        header('Location: ' . root . '/campagne.php/gererCampagne');
    }

}

new CampagneController();
?>
