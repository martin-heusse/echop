<?php
require_once("Model/Administrateur.php");
require_once("Model/Utilisateur.php");
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
<?php
    if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
?>
    <!-- Menu administrateur -->
    <h1 class="titre_menu">Campagne courante</h1>
    <ul>
        <li><a href="<?php echo root ?>/campagne.php/gererCampagne">Gérer la campagne courante</a></li>
        <li><a href="<?php echo root ?>/commande.php/articlesCommandEs">Articles commandés</a></li>
        <li><a href="<?php echo root ?>/commande.php/utilisateurAyantCommandE">Utilisateurs ayant commandés</a></li>
        <li><a href="<?php echo root ?>/articleCampagne.php/fournisseursChoisis">Fournisseurs choisis</a></li>
    </ul>
    <h1 class="titre_menu">Administration</h1>
    <ul>
        <li><a href="<?php echo root ?>/rayon.php/gererRayon">Gérer les rayons</a></li>
        <li><a href="<?php echo root ?>/utilisateur.php/listeUtilisateur">Liste des utilisateurs</a></li>
        <li><a href="<?php echo root ?>/fournisseur.php/tousLesFournisseurs">Liste des fournisseurs</a></li>
        <li><a href="<?php echo root ?>/campagne.php/historiqueCampagne">Historique des campagnes</a></li>
    </ul>
<?php
    }
?>
    <!-- Menu utilisateur -->
    <h1 class="titre_menu">Menu</h1>
    <ul>
        <li><a href="<?php echo root ?>/commande.php/commanderArticle">Commander des articles</a></li>
        <li><a href="<?php echo root ?>/commande.php/mesCommandes">Mes commandes</a></li>
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
