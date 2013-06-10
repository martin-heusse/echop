<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Gérer les rayons</h1>

<?php
foreach ($to_rayon as $o_rayon) {
?>

<!-- affichage de la liste des rayons -->
<a href="http://localhost/echoppe/rayon.php/gererRayon?id_rayon=<?php echo $o_rayon['id'] ?>">
<?php echo $o_rayon['nom'] ?>
</a>
<?php
}
?>
<!-- par défaut pas de rayon -->
<!-- reste à vérifier que l'utilisateur ne peut pas rentrer n'importe quoi dans l'URL -->
<?php
if ( isset($_GET['id_rayon']) ) {
?>
<p> Il y a un rayon !</p>


<?php
} else { 
?>
<p> Choisissez votre rayon !</p>
<?php
}
?>
