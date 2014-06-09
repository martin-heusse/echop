<!-- affichage de la commande d'un utilisateur pour un article donné-->
<div id="retour">
<p><a class="action_navigation" href="<?php echo root ?>/articlesCommandEs.php/utilisateursAyantCommandECetArticle?idArticle=<?php echo $i_idArticle ?>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "&idOldCampagne=".$i_idCampagne;
}
?>
">Retour aux utilisateurs ayant commandé cet article</a></p>
</div>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
    <span class="historique">[Historique de la campagne n°<?php echo $i_idCampagne ?>]</span>
<?php
}
?>
<h1>Commande de <?php echo $s_login ?> pour cet article</h1>

<?php
if ($o_commande != null and $o_commande != array()) {
    /* on affiche la commande si elle existe */
?>

<form method="post" action="articlesCommandEs.php/modifierQuantiteUtilisateur?idArticle=<?php echo $i_idArticle ?>&idUtilisateur=<?php echo $i_idUtilisateur ?>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "&idOldCampagne=".$i_idCampagne;
}
?>
">
<table>
    <tr>
        <th>Produit</th>
        <th>Description</th>
        <th>Poids du paquet du fournisseur</th>
        <th>Nombre de paquets par colis</th>
        <th>Prix TTC</th>
        <th>Prix TTC unitaire (au kilo ou litre)</th>
        <th>Poids unitaire que le client peut commander</th>   
        <th>Quantité minimale que l'on peut commander</th>
        <th>Quantité</th>
        <th>Quantité totale commandée</th>
        <th>Total TTC</th>
        <th>Suppression d'un article</th>
    </tr>
<?php 
    $i_numLigne = 0;
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
        <td><?php echo $o_commande['nom'] ?></td>
        <td title="<?php echo $o_commande['description_longue']?>"><?php echo $o_commande['description_courte'] ?></td>
        <td class="centrer"><?php echo $o_commande['poids_paquet_fournisseur'] ?><?php echo $o_commande['unite'] ?></td>
        <td class="centrer"><?php echo $o_commande['nb_paquet_colis'] ?></td>
        <td class="centrer"><?php echo $o_commande['prix_ttc'] ?>&euro;</td>
        <td class="centrer"><?php echo $o_commande['prix_unitaire'] ?>&euro;/<?php echo $o_commande['unite'] ?></td>
        <td class="centrer"><?php echo $o_commande['poids_paquet_client'] ?><?php echo $o_commande['unite'] ?></td>
        <td class="centrer"><?php echo $o_commande['seuil_min'] ?></td>
        <td><input class="input_quantite" type="text" name="quantite[<?php echo $o_commande['id_article']?>]" value="<?php echo $o_commande['quantite'] ?>"/></td>
        <td class="centrer col_coloree"><?php echo $o_commande['quantite_totale'] ?><?php echo $o_commande['unite'] ?></td>
        <td class="centrer col_coloree"><?php echo $o_commande['total_ttc'] ?>&euro;</td>
        <td class="centrer"><a href="<?php echo root ?>/articlesCommandEs.php/supprimerArticleUtilisateur?idUtilisateur=<?php echo $i_idUtilisateur ?>&idArticle=<?php echo $o_commande['id_article']?>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "&idOldCampagne=".$i_idCampagne;
}
?>
">supprimer l'article</a>
    </tr>
<?php
    $i_numLigne = ($i_numLigne + 1) % 2;
?>  
</table>
<input class="input_valider" type="submit" value="Mettre à jour les quantités"/>
</form>
<?php
} else {
?>
<p class="message">Vous n'avez pas de commande en cours.</p>
<?php
}
?>
