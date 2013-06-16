<p><a class="action_navigation" href="<?php echo root ?>/articlesCommandEs.php/articlesCommandEs
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "?idOldCampagne=".$i_idCampagne;
}
?>
">Retour aux articles commandés</a></p>

<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
    <span class="historique">[Historique de la campagne n°<?php echo $i_idCampagne ?>]</span>
<?php
}
?>

<h1>Utilisateurs ayant commandé cet article</h1>

<?php
if ($to_utilisateur == null or $to_utilisateur == array()) {
?>
<p>Aucun utilisateur n'a commandé l'article <strong><?php echo $s_nomArticle ?></strong>.</p>
<?php
} else {
?>
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
        <td><a href="<?php echo root ?>/articlesCommandEs.php/commandeUtilisateurPourCetArticle?idArticle=<?php echo $i_idArticle ?>&idUtilisateur=<?php echo $o_utilisateur['id']?>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "&idOldCampagne=".$i_idCampagne;
}
?>
"><?php echo $o_utilisateur['login'] ?></a></td>
        <td class="centrer"><?php echo $o_utilisateur['quantite'].$s_unite ?></td>
    </tr>
<?php
        $i_numLigne = ($i_numLigne + 1) % 2;
    }
?>
    <tr>
        <th class="left">Quantité totale commandée</th>
        <td class="centrer"><?php echo $i_quantiteTotale.$s_unite?> </td>
    </tr>
    <tr>
        <th class="left">Quantité pour le colisage </th>
        <td class="centrer">multiple de <?php echo $i_colisage.$s_unite ?> </td>
    </tr>
    <tr>
        <th class="left">Quantité manquante </th>
        <td class="centrer"><?php echo $i_manque.$s_unite ?></td>
    </tr>
</table>
<?php
}
?>
