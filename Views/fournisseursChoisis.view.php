<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Commandes par fournisseur</h1>

<p>Liste de tous les founisseurs choisis pour la campagne courante.<br/>
Cliquez sur un nom de fournisseur pour voir les commandes associées pour la campagne courante.</p>

<table>
    <tr>
        <th>Fournisseur</th>
        <th>Prix total HT</th>
        <th>Prix total TTC</th>
    </tr>
<?php
$i_numLigne = 0;
foreach ($to_fournisseur as $o_fournisseur) {
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
        <td><a href="<?php echo root ?>/fournisseur.php/commandeFournisseur?idFournisseur=<?php echo $o_fournisseur['id'] ?>">
        <?php echo $o_fournisseur['nom'] ?></a></td>
        <td><?php echo $o_fournisseur['prix_ht'] ?></td>
        <td><?php echo $o_fournisseur['prix_ttc'] ?></td>
    </tr>
<?php
    $i_numLigne = ($i_numLigne + 1) % 2;
}
?>
</table>
