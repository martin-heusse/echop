<!-- affiche la liste de tous les utilisateurs qui ont passé une commande -->
<div id="retour">
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
</div>

<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
    <span class="historique">[Historique de la campagne n°<?php echo $i_idCampagne ?>]</span>
<?php
}
?>

<h1>Liste des utilisateurs ayant commandé</h1>

<?php
if ($to_commande != null) {
?> 
<!--<p>Liste des utilisateurs ayant passé une commande pour la campagne courante.<br/>-->
Cliquez sur un nom d'utilisateur pour voir la liste des produits qu'il a commandé.</p>

<table>
    <tr>
        <th>Utilisateur</th>
        <th>Prix total TTC</th>
        <th>A réceptionné <br /> toute sa commande</th>
    </tr>
<?php
    $i_numLigne = 0;
    $montantTotal = 0;
    foreach($to_commande as $o_utilisateur) {
        $montantTotal+=$o_utilisateur['montant_total'];
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
        <td><a href="<?php echo root ?>/utilisateurAyantCommandE.php/commandeUtilisateur?idUtilisateur=<?php echo $o_utilisateur['id_utilisateur']?>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "&idOldCampagne=".$i_idCampagne;
}
?>
">
        <?php echo $o_utilisateur['nom'] ?> <?php echo $o_utilisateur['prenom'] ?> <small>(<?php echo $o_utilisateur['login_utilisateur'] ?>)</small></a></td>
        <td class="centrer"><?php echo $o_utilisateur['montant_total'] ?>&euro;</td>
<?php
if ($o_utilisateur['tout_livre'] == 1) {
?>
        <td class="center">oui</td>
<?php
} else {
?>
        <td class="center col_coloree">non</td>
<?php
}
?>
    </tr>
<?php
    $i_numLigne = ($i_numLigne + 1) % 2;
    }
?>
    
    <tr> <th colspan=<?php echo $i_colspan ?> class="right">Montant Total = </th>
        <td class="center"><?php echo $montantTotal ?> €</td></tr>
</table>
<p><a class="action_navigation" href="<?php echo root ?>/utilisateurAyantCommandE.php/exportCSVAll<?php echo "?idOldCampagne=".$i_idCampagne;?>"><img height="40" id="logo" src="<?php echo root ?>/Layouts/images/excel.png" alt="<?php echo $titre_page ?>" /></a></p>
<p><a class="action_navigation" href="<?php echo root ?>/utilisateurAyantCommandE.php/exportPDFAll<?php echo "?idOldCampagne=".$i_idCampagne;?>"><img height="40" id="logo" src="<?php echo root ?>/Layouts/images/pdf.png" alt="<?php echo $titre_page ?>" /></a></p>
<p><a class="action_navigation" href="<?php echo root ?>/utilisateurAyantCommandE.php/etiquettesUtilisateurAll<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "?idOldCampagne=".$i_idCampagne;
}
?>
"><img height="60" id="logo" src="<?php echo root ?>/Layouts/images/multitag.png" alt="<?php echo 'Générer les étiquettes' ?>"/></a></p>

<?php
} else {
?>
<p class="message"> Aucun utilisateur n'a fait de commande pour la campagne courante.</p>
<?php
}
?>