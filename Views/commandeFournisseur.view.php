<p><a class="action_navigation" href="<?php echo root ?>/articleCampagne.php/fournisseursChoisis">Retour</a></p>

<h1>Commande fournisseur</h1>

<ul>
<?php
foreach ($to_article as $o_article) {
?>
    <li><?php echo $o_article['nom'] ?></li>
<?php
}
?>
</ul>
