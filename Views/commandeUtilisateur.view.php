<p><a class="action_navigation" href="<?php echo root ?>/commande.php/utilisateurAyantCommandE">Retour aux utilisateurs ayant commandé</a></p>

<h1>Commande de <?php echo $s_login ?></h1>

<?php
if ($to_commande != null and $to_commande != array()) {
?>

<form method="post" action="<?php echo root ?>/commande.php/modifierQuantiteUtilisateur?idUtilisateur=<?php echo $i_idUtilisateur ?>">
<table>
    <tr>
        <th>Produit</th>
        <th>Description</th>
        <!--
         <th>Description longue</th>
         -->
        <th>Poids du paquet du fournisseur</th>
        <!-- <th>Unité</th> -->
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
    foreach($to_commande as $o_produit) {
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
        <td><?php echo $o_produit['nom'] ?></td>
        <td title="<?php echo $o_produit['description_longue']?> "><?php echo $o_produit['description_courte'] ?></td>
        <td class="centrer"><?php echo $o_produit['poids_paquet_fournisseur'] ?><?php echo $o_produit['unite'] ?></td>
        <!-- <td class="centrer"><?php echo $o_produit['unite'] ?></td> -->
        <td class="centrer"><?php echo $o_produit['nb_paquet_colis'] ?></td>
        <td class="centrer"><?php echo $o_produit['prix_ttc'] ?>&euro;</td>
        <td class="centrer"><?php echo $o_produit['prix_unitaire'] ?>&euro;/<?php echo $o_produit['unite'] ?></td>
        <td class="centrer"><?php echo $o_produit['poids_paquet_client'] ?><?php echo $o_produit['unite'] ?></td>
        <td class="centrer"><?php echo $o_produit['seuil_min'] ?></td>
        <td><input class="input_quantite" type="text" name="quantite[<?php echo $o_produit['id_article']?>]" value="<?php echo $o_produit['quantite'] ?>"/></td>
        <td class="centrer col_coloree"><?php echo $o_produit['quantite_totale'] ?><?php echo $o_produit['unite'] ?></td>
        <td class="centrer col_coloree"><?php echo $o_produit['total_ttc'] ?>&euro;</td>
        <td class="centrer"><a href="<?php echo root ?>/commande.php/supprimerArticleUtilisateur?idUtilisateur=<?php echo $i_idUtilisateur ?>&id_article=<?php echo $o_produit['id_article']?>">supprimer l'article</a>
    </tr>
<?php
    $i_numLigne = ($i_numLigne + 1) % 2;
   }
?>  
    <tr>
        <th colspan=10 class="right">Montant Total = </th>
        <td class="centrer"><strong><?php echo $f_montantTotal ?>&euro;</strong></td>
        <td>&nbsp;</td>
    </tr>
</table>
<input class="input_valider" type="submit" value="Mettre à jour les quantités"/>
</form>
<?php
} else {
?>
<p>Vous n'avez pas de commande en cours.</p>
<?php
}
?>
