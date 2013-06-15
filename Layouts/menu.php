<?php
require_once("Model/Administrateur.php");
require_once("Model/Utilisateur.php");
require_once("Model/Campagne.php");
?>
<div id="menu">
<?php
if (Utilisateur::isLogged()) {
?>
<?php
    $bonjour = $_SESSION['login'];
    if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
        $bonjour .= " (admin)";
    }
?>
    <!-- Commun à tous les utilisateurs -->
    <span id="bonjour">Bonjour <?php echo $bonjour ?>,</span>
    <ul>
        <li><a href="<?php echo root ?>/accueil.php/accueil">Accueil</a></li>
        <li><a href="<?php echo root ?>/connexion.php/deconnexion">Se déconnecter</a></li>
    </ul>
    <!-- Menu administrateur -->
    <h1 class="titre_menu">Campagne n°<?php echo Campagne::getIdCampagneCourante() ?></h1>
    <ul>
<?php
    if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
?>
        <li><a href="<?php echo root ?>/campagne.php/gererCampagne">Gérer les campagnes</a></li>
        <li><a href="<?php echo root ?>/commande.php/utilisateurAyantCommandE">Utilisateurs ayant commandés</a></li>
        <li><a href="<?php echo root ?>/fournisseur.php/fournisseursChoisis">Commandes par fournisseur</a></li>
<?php 
    }
?>
        <li><a href="<?php echo root ?>/commande.php/articlesCommandEs">Articles commandés</a></li>
    </ul>
<?php
    if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
?>

    <h1 class="titre_menu">Administration</h1>
    <ul>
        <li><a href="<?php echo root ?>/article.php/afficherArticle">Gérer articles</a></li>
        <li><a href="<?php echo root ?>/rayon.php/afficherRayon">Gérer les rayons </a></li>
        <li><a href="<?php echo root ?>/rayon.php/afficherRayon">Gérer les TVA</a></li>
        <li><a href="<?php echo root ?>/fournisseur.php/tousLesFournisseurs">Gérer des fournisseurs</a></li>
        <li><a href="<?php echo root ?>/utilisateur.php/listeUtilisateurAValider">Inscriptions à valider (<?php echo Utilisateur::getCountByValidite(0) ?>)</a></li>
        <li><a href="<?php echo root ?>/utilisateur.php/listeUtilisateurValide">Liste des utilisateurs</a></li>
        <li><a href="<?php echo root ?>/campagne.php/historiqueCampagne">Historique des campagnes</a></li>
        <li><a href="<?php echo root ?>/utilisateur.php/envoiMail">Envoyer un mail à tous les utilisateurs</a></li>
    </ul>
<?php
    }
?>
    <!-- Menu utilisateur -->
    <h1 class="titre_menu">Menu</h1>
    <ul>
        <li><a href="<?php echo root ?>/mesCommandes.php/mesCommandes">Mes commandes</a></li>
        <li><a href="<?php echo root ?>/commanderArticle.php/afficherRayon">Commander des articles</a></li>
        <li><a href="<?php echo root ?>/utilisateur.php/profil">Mon profil</a></li>
     </ul>
<?php
} else {
?>
    <ul>
        <li><a href="<?php echo root ?>/index.php">Accueil</a></li>
        <li><a href="<?php echo root ?>/connexion.php/connexion">Se connecter</a></li>
    </ul>
<?php
}
?>

</div><!-- id="menu" -->
