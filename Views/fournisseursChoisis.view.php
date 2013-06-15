<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
<p><a class="action_navigation" href="<?php echo root ?>/campagne.php/gererCampagne">Retour à la gestion des campagnes</a></p>
<?php
} else {
?>
<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>
<?php
}
?>

<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
    <span class="historique">[Historique de la campagne n°<?php echo $i_idCampagne ?>]</span>
<?php
}
?>
<h1>Commandes par fournisseur</h1>

<?php
if ($to_fournisseur == null or $to_fournisseur == array()) {
?>
<p>Aucun fournisseur n'a été choisis pour les articles de cette campagne.</p>
<?php
} else {
?>

<p>Liste de tous les founisseurs choisis pour la campagne courante.<br/>
Cliquez sur un nom de fournisseur pour voir les commandes associées pour la campagne courante.</p>

<table>
    <tr>
        <th>Fournisseur</th>
        <th>Prix total TTC</th>
    </tr>
<?php
$i_numLigne = 0;
foreach ($to_fournisseur as $o_fournisseur) {
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
        <td><a href="<?php echo root ?>/fournisseur.php/commandeFournisseur?idFournisseur=<?php echo $o_fournisseur['id'] ?>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "&idOldCampagne=".$i_idCampagne;
}
?>
">
        <?php echo $o_fournisseur['nom'] ?></a></td>
        <td class="centrer"><?php echo $o_fournisseur['montant_total'] ?>&euro;</td>
    </tr>
<?php
    $i_numLigne = ($i_numLigne + 1) % 2;
}
?>
</table>
<?php
}
?>
