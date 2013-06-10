<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Historique des campagnes passés</h1>

<table>
    <tr>
        <th>Numéro</th>
        <th>Date de début</th>
    </tr>
<?php
$i_numLigne = 0;
foreach ($to_campagne as $o_campagne) {
?>
    <tr class="ligne_article<?php echo $i_numLigne?>">
    <td><?php echo $o_campagne['id'] ?></td>
    <td><?php echo $o_campagne['date_debut'] ?></td>
    </tr>
<?php
    $i_numLigne = ($i_numLigne + 1) % 2;
}
?>
</table>
