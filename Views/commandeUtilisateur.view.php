<!-- Affiche les commandes pour chaque utilisateur -->
<p><a class="action_navigation" href="<?php echo root ?>/utilisateurAyantCommandE.php/utilisateurAyantCommandE
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "?idOldCampagne=".$i_idCampagne;
}
?>
">Retour aux utilisateurs ayant commandé</a></p>

<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
    <span class="historique">[Historique de la campagne n°<?php echo $i_idCampagne ?>]</span>
<?php
}
?>

<h1>Commande de <?php echo $s_login ?></h1>

<?php
if ($to_commande != null and $to_commande != array()) {
?>

<form method="post" action="<?php echo root ?>/utilisateurAyantCommandE.php/modifierQuantiteUtilisateur?idUtilisateur=<?php echo $i_idUtilisateur ?>
<?php
    /* Si navigation dans l'historique on affiche le numéro de la campagne */
    if ($b_historique == 1) {
        echo "&idOldCampagne=".$i_idCampagne;
    }
    /* affichage du tableau qui récapitule la commande pour un utilisateur donné */
?>
">
<table>
    <tr>
        <th>A réceptionné le produit</th>
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
    foreach($to_commande as $o_produit) {
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
    <td class="centrer"><input type="checkbox" name="est_livre[<?php echo $o_produit['id_article']?>]" value="1"
<?php 
        /* est_livre checked */
        if ($o_produit['est_livre'] == 1) {
?>
checked
<?php
        }
?>
        ></td>
        <td><?php echo $o_produit['nom'] ?></td>
        <td title="<?php echo $o_produit['description_longue']?> "><?php echo $o_produit['description_courte'] ?></td>
        <td class="centrer"><?php echo $o_produit['poids_paquet_fournisseur'] ?><?php echo $o_produit['unite'] ?></td>
        <td class="centrer"><?php echo $o_produit['nb_paquet_colis'] ?></td>
        <td class="centrer"><?php echo $o_produit['prix_ttc'] ?>&euro;</td>
        <td class="centrer"><?php echo $o_produit['prix_unitaire'] ?>&euro;/<?php echo $o_produit['unite'] ?></td>
        <td class="centrer"><?php echo $o_produit['poids_paquet_client'] ?><?php echo $o_produit['unite'] ?></td>
        <td class="centrer"><?php echo $o_produit['seuil_min'] ?></td>
        <td><input class="input_quantite" type="text" name="quantite[<?php echo $o_produit['id_article']?>]" value="<?php echo $o_produit['quantite'] ?>"/></td>
        <td class="centrer col_coloree"><?php echo $o_produit['quantite_totale'] ?><?php echo $o_produit['unite'] ?></td>
        <td class="centrer col_coloree"><?php echo $o_produit['total_ttc'] ?>&euro;</td>
        <td class="centrer"><a href="<?php echo root ?>/utilisateurAyantCommandE.php/supprimerArticleUtilisateur?idUtilisateur=<?php echo $i_idUtilisateur ?>&id_article=<?php echo $o_produit['id_article']?>
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
    }
?>  
    <tr>
<?php
    $i_colspan = 11;
?>
    <th colspan=<?php echo $i_colspan ?> class="right">Montant Total = </th>
        <td class="centrer"><strong><?php echo $f_montantTotal ?>&euro;</strong></td>
        <td>&nbsp;</td>
    </tr>
    
    <?php 
    foreach($f_montantParRayon as $nom_rayon=>$montant){
    ?>
    <tr>
    <th colspan=<?php echo $i_colspan ?> class="right"> <?php echo $nom_rayon ." : " ?> </th>
        <td class="right"><?php echo $montant ?>&euro;</td>
        <td>&nbsp;</td>
    </tr>
    </tr>
     <?php 
    }
    ?>
    
</table>
<input class="input_valider" type="submit" value="Mettre à jour<?php if ($b_historique == 0) { echo " les quantités"; } ?>
"/>
</form>
<?php
} else {
?>
<p class="message">Vous n'avez pas de commande en cours.</p>
<?php
}
?>
