<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Articles commandés</h1>

<ul>
<?php
foreach ($to_article as $o_article) {
?>
    <li><a href="<?php echo root ?>/commande.php/utilisateursAyantCommandECetArticle?idArticle=<?php echo $o_article['id_article']?>"><?php echo $o_article['nom']?></a></li>
<?php
}
?>
</ul>
