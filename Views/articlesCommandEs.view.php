<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Articles commandés</h1>

<p>Liste de tous les articles commandés par les utilisateurs pendant la campagne en cours.<br/>
Cliquez sur l'un des articles pour voir la liste de tous les utilisateurs l'ayant commandé.</p>

<ul>
<?php
foreach ($to_article as $o_article) {
?>
    <li><a href="<?php echo root ?>/commande.php/utilisateursAyantCommandECetArticle?idArticle=<?php echo $o_article['id_article']?>"><?php echo $o_article['nom']?></a></li>
<?php
}
?>
</ul>
