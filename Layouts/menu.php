<?php
require_once("Model/Administrateur.php");
require_once("Model/Utilisateur.php");
?>
<div id="menu">
<?php
if (Utilisateur::isLogged()) {
?>
    <!-- Commun à tous les utilisateurs -->
    <span id="bonjour">Bonjour <?php echo $_SESSION['login'] ?>,</span>
    <ul>
        <li><a href="<?php echo root ?>/index.php">Accueil</a></li>
        <li><a href="<?php echo root ?>/connexion.php/deconnexion">Se déconnecter</a></li>
    </ul>
    <!-- Menu utilisateur -->
    <ul>
        <li><a href="<?php echo root ?>/index.php">lien utilisateur</a></li>
        <li><a href="<?php echo root ?>/index.php">lien utilisateur</a></li>
        <li><a href="<?php echo root ?>/index.php">lien utilisateur</a></li>
    </ul>
    <!-- Menu administrateur -->
    <ul>
        <li><a href="<?php echo root ?>/index.php">lien admin</a></li>
        <li><a href="<?php echo root ?>/index.php">lien admin</a></li>
        <li><a href="<?php echo root ?>/index.php">lien admin</a></li>
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
if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
?>
    <p>Vous êtes administrateur.</p>
<?php
}
?>

</div><!-- id="menu" -->
