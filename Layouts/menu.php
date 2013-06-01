<?php
require_once("Model/Admin.php");
require_once('Model/Categorie.php');
?>
<div id="menu">
<?php
if (Admin::isLogged()) {
?>
    <span id="bonjour">Bonjour <?php echo $_SESSION['nom'] ?>,</span>
    <ul>
        <li><a href="<?php echo root ?>/index.php">Accueil</a></li>
        <li><a href="<?php echo root ?>/connexion.php/deconnexion">Se déconnecter</a></li>
    </ul>
<?
} else {
?>
    <ul>
        <li><a href="<?php echo root ?>/index.php">Accueil</a></li>
        <li><a href="<?php echo root ?>/connexion.php/connexion">Se connecter</a></li>
    </ul>
<?php
}
?>

<?php
if(Admin::isLogged()) {
?>
    <h1 class="titre_menu">Catégories</h1>
    <ul>
<?php
    $to_allCategories = Categorie::getAllObjects();
    foreach ($to_allCategories as $row) {
?>
    <li><a href="<?php echo root ?>/article.php/afficher?idcat=<?php echo $row['id'] ?>"><?php echo $row['nom'] ?></a></li>
<?php
    }
?>
    </ul>
<?php
}
?>
</div><!-- id="menu" -->
