<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Gérer les rayons</h1>

<?php
// Trace
// print_r($to_descriptionArticle);
// print_r($to_fournisseur);
?>

<p> La liste des actions : </p>
<a href="<?php echo root ?>/rayon.php/creerRayon"> créer un rayon <a/>
<a href="<?php echo root ?>/rayon.php/modifierRayon"> modifier un rayon <a/>
<p> La liste des rayons : </p>
<?php
foreach ($to_rayon as $o_rayon) {
?>
<!-- affichage de la liste des rayons -->
<a href="<?php echo root ?>/article.php/afficherArticle?i_idRayon=<?php echo $o_rayon['id'] ?>">
<?php echo $o_rayon['nom'] ?>
</a>
&nbsp
<?php
}
?>
