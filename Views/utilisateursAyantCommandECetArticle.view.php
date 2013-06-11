<p><a class="action_navigation" href="<?php echo root ?>/commande.php/articlesCommandEs">Retour aux articles commandés</a></p>

<h1>Utilisateurs ayant commandé cet article</h1>

<p>Liste des utilisateurs ayant commandé l'article <strong><?php echo $s_nomArticle ?></strong>.<br/>
Cliquez sur un nom pour voir ses commandes.</p>

<table>
    <tr>
        <th>Utilisateur</th>
        <th>Quantité commandée</th>
    </tr>
<?php
$i_numLigne = 0;
foreach ($to_utilisateur as $o_utilisateur) {
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
        <td><a href="<?php echo root ?>/commande.php/commandeUtilisateur?idUtilisateur=<?php echo $o_utilisateur['id']?>"><?php echo $o_utilisateur['login'] ?></a></td>
        <td><?php echo $o_utilisateur['quantite'] ?></td>
    </tr>
<?php
    $i_numLigne = ($i_numLigne + 1) % 2;
}
?>
</table>
