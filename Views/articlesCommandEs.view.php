<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Articles commandés</h1>

<p>Liste de tous les articles commandés par les utilisateurs pendant la campagne en cours.<br/>
Cliquez sur l'un des articles pour voir la liste de tous les utilisateurs l'ayant commandé.</p>

<table>
    <tr>
        <th>Article</th>
        <th>Quantité totale commandée</th>
    </tr>
<?php
$i_numLigne = 0;
foreach ($to_article as $o_article) {
?>
    <tr class="ligne_article<?php echo $i_numLigne?>">
        <td><a href="<?php echo root ?>/commande.php/utilisateursAyantCommandECetArticle?idArticle=<?php echo $o_article['id_article']?>">
        <?php echo $o_article['nom']?></a></td>
        <td><?php echo $o_article['quantite'] ?></td>
    </tr>
<?php
    $i_numLigne = ($i_numLigne + 1) % 2;
}
?>
</table>
