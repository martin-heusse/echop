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
        <li><a href="<?php echo root ?>/index.php">Accueil</a></li>
        <li><a href="<?php echo root ?>/connexion.php/deconnexion">Se déconnecter</a></li>
    </ul>
<?php
    if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
?>
    <!-- Menu administrateur -->
    <ul>
        <li><a href="<?php echo root ?>/rayon.php/gererRayon">Gérer les rayon</a></li>
    </ul>
<?php
    }
?>
    <!-- Menu utilisateur -->
    <ul>
        <li><a href="<?php echo root ?>/article.php/commanderArticle">Commander des articles</a></li>
        <li><a href="<?php echo root ?>/commande.php/maCommande">Ma commande</a></li>
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
