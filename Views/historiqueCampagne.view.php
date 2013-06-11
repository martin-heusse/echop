<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Historique des campagnes passés</h1>

<?php 
if ($to_campagne == null or $to_campagne == array()) {
?>
<p>Il n'y pas aucune campagne archivée.</p>
<?php
} else {
?>
<table>
    <tr>
        <th>Numéro</th>
        <th>Date de début</th>
        <th>Commandes précédentes</th>
    </tr>
<?php
    $i_numLigne = 0;
    foreach ($to_campagne as $o_campagne) {
?>
    <tr class="ligne_article<?php echo $i_numLigne?>">
    <td><?php echo $o_campagne['id'] ?></td>
    <td><?php echo $o_campagne['date_debut'] ?></td>
    <td><a href="<?php echo root ?>/commande.php/utilisateurAyantCommandE?idCampagne=<?php echo $o_campagne['id'] ?>">Voir les commandes précédentes</a></td>
    </tr>
<?php
        $i_numLigne = ($i_numLigne + 1) % 2;
    }
?>
</table>
<?php
}
?>
