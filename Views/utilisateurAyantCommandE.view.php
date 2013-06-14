<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Liste des utilisateurs ayant commandé</h1>

<p>Liste des utilisateurs ayant passé une commande pour la campagne courante.<br/>
Cliquez sur un nom d'utilisateur pour voir la liste des produits qu'il a commandé.</p>

<?php
if ($to_commande != null) {
?> 
<table>
    <tr>
        <th>Utilisateur</th>
        <th>Prix total TTC</th>
    </tr>
<?php
    $i_numLigne = 0;
    foreach($to_commande as $o_utilisateur) {
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
        <td><a href="../commande.php/commandeUtilisateur?idUtilisateur=<?php echo $o_utilisateur['id_utilisateur']?>">
        <?php echo $o_utilisateur['login_utilisateur'] ?></a></td>
        <td class="centrer"><?php echo $o_utilisateur['montant_total'] ?>&euro;</td>
    </tr>
<?php
    $i_numLigne = ($i_numLigne + 1) % 2;
    }
?>
</table>
<?php
} else {
?>
<p> Aucun utilisateur n'a fait de commande pour la campagne courante.</p>
<?php
}
?>

