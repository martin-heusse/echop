<p><a class="action_navigation" href="<?php echo root ?>/commande.php/utilisateursAyantCommandECetArticle?idArticle=<?php echo $i_idArticle ?>">Retour aux utilisateurs ayant commandé cet article</a></p>

<h1>Commande de <?php echo $s_login ?> pour cet article</h1>

<?php
if ($o_commande != null and $o_commande != array()) {
?>

<form method="post" action="commande.php/modifierQuantiteUtilisateur?idArticle=<?php echo $i_idArticle ?>&idUtilisateur=<?php echo $i_idUtilisateur ?>">
<table>
    <tr>
        <th>Produit</th>
        <!--
        <th>Description courte</th>
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
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
        <td><?php echo $o_commande['nom'] ?></td>
        <!--
        <td><?php echo $o_commande['description_courte'] ?></td>
        <td><?php echo $o_commande['description_longue'] ?></td>
        --> 
        <td class="centrer"><?php echo $o_commande['poids_paquet_fournisseur'] ?><?php echo $o_commande['unite'] ?></td>
        <!-- <td class="centrer"><?php echo $o_commande['unite'] ?></td> -->
        <td class="centrer"><?php echo $o_commande['nb_paquet_colis'] ?></td>
        <td class="centrer"><?php echo $o_commande['prix_ttc'] ?>&euro;</td>
        <td class="centrer"><?php echo $o_commande['prix_unitaire'] ?>&euro;/<?php echo $o_commande['unite'] ?></td>
        <td class="centrer"><?php echo $o_commande['poids_paquet_client'] ?><?php echo $o_commande['unite'] ?></td>
        <td class="centrer"><?php echo $o_commande['seuil_min'] ?></td>
        <td><input class="input_quantite" type="text" name="quantite[<?php echo $o_commande['id_article']?>]" value="<?php echo $o_commande['quantite'] ?>"/></td>
        <td class="centrer col_coloree"><?php echo $o_commande['quantite_totale'] ?><?php echo $o_commande['unite'] ?></td>
        <td class="centrer col_coloree"><?php echo $o_commande['total_ttc'] ?>&euro;</td>
        <td class="centrer"><a href="../commande.php/supprimerArticleUtilisateur?idUtilisateur=<?php echo $i_idUtilisateur ?>&id_article=<?php echo $o_commande['id_article']?>">supprimer l'article</a>
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
<p>Vous n'avez pas de commande en cours.</p>
<?php
}
?>