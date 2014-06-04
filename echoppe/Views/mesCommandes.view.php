<!-- affiche un récapitulatif de la commande effectuée par un utilisateur donné -->
<p><a class="action_navigation" href="<?php echo root ?>/campagne.php/historiqueCampagne">Explorer une autre campagne</a></p>

<?php if ($to_commande[0]['id_campagne'] != null) { ?>

<h1>Mes Commandes de la Campagne n°<?php echo $to_commande[0]['id_campagne']?></h1>

<?php } else if ($_GET['id_camp']!=null){ ?>

<h1>Pas de Commande pour la Campagne n°<?php echo $_GET['id_camp']?></h1>

<?php } ?>

<!-- Indication de campagne -->
<?php
    /* Indique si la campagne est ouverte ou non */
    if ($b_etat == 1) {
?>
<div class="indication_campagne"><span class="campagne_ouverte">Campagne ouverte</span></div>
<?php
    } else {
?>
<div class="indication_campagne"><span class="campagne_fermee">Campagne fermée</span></div>
<?php
    }
?>

<?php
if ($to_commande != null and $to_commande != array()) {
?>

<?php
    /* Affiche ou non le formulaire */
    if ($b_etat == 1) {
?>
    <form method="post" action="<?php echo root ?>/mesCommandes.php/mesCommandesModifier">
<?php
    }
?>
<table id="t_article">
    <tr>
        <th>Produit</th>
        <th>Description</th>
        <th>Code Fournisseur</th>
        <th>Poids du paquet du fournisseur</th>
        <th>Nombre de paquets par colis</th>
        <th>Prix TTC</th>
        <th>Prix TTC unitaire (au kilo ou litre)</th>
        <th>Poids unitaire que le client peut commander</th>   
        <th>Quantité minimale que l'on peut commander</th>
        <th>Quantité</th>
        <th>Quantité totale commandée</th>
        <th>Total TTC</th>
<?php
        /* Affiche ou non la colonne de suppression */
        if ($b_etat == 1) {
?>
        <th>Suppression d'un article</th>
<?php
        }
?>
    </tr>
<?php 
    $i_numLigne = 0;
    foreach($to_commande as $o_produit) {
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
        <td><?php echo $o_produit['nom'] ?></td>
        <td class="center" title="<?php echo $o_produit['description_longue']?>"><?php echo $o_produit['description_courte'] ?></td>
        <td class="centrer"><?php echo $o_produit['code'] ?></td>
        <td class="centrer"><?php echo $o_produit['poids_paquet_fournisseur'].$o_produit['unite'] ?></td>
        <td class="centrer"><?php echo $o_produit['nb_paquet_colis'] ?></td>
        <td class="centrer"><?php echo $o_produit['prix_ttc'] ?>&euro;</td>
        <td class="centrer"><?php echo $o_produit['prix_unitaire'] ?>&euro;/<?php echo $o_produit['unite'] ?></td>
        <td class="centrer"><?php echo $o_produit['poids_paquet_client'] ?><?php echo $o_produit['unite'] ?></td>
        <td class="centrer"><?php echo $o_produit['seuil_min'] ?></td>
<?php
        /* Bloquer ou autoriser la modification de la quantité */
        if ($b_etat == 1) {
?>
        <td><input class="input_quantite" type="text" name="quantite[<?php echo $o_produit['id_article']?>]" value="<?php echo $o_produit['quantite'] ?>"/></td>
<?php
        } else {
?>
        <td class="centrer"><?php echo $o_produit['quantite'] ?></td>
<?php
        }
?>
    <td class="centrer col_coloree"><?php echo $o_produit['quantite_totale'] ?><?php echo $o_produit['unite'] ?></td>
        <td class="centrer col_coloree"><?php echo $o_produit['total_ttc'] ?>&euro;</td>
<?php
        /* Affiche ou non le lien de suppression */
        if ($b_etat == 1) {
?>
        <td class="centrer"><a href="<?php echo root ?>/mesCommandes.php/mesCommandesSupprimer?id_article=<?php echo $o_produit['id_article']?>">supprimer l'article</a>
<?php
        }
?>
    </tr>
<?php
    $i_numLigne = ($i_numLigne + 1) % 2;
   }
?>  
    <tr>
        <th colspan=10 class="right">Montant Total = </th>
        <td class="centrer"><strong><?php echo $f_montantTotal ?>&euro;</strong></td>
<?php
    /* Afficher ou non la dernière colonne dans la ligne "Montant total" */
    if ($b_etat == 1) {
?>
        <td>&nbsp;</td>
<?php
    }
?>
    </tr>
</table>
<?php
    /* Affiche ou non le bouton de mise à jour */
    if ($b_etat == 1) {
?>
<input class="input_valider" type="submit" value="Mettre à jour les quantités"/>
</form>
<?php
    }
?>
<p><a class="action_navigation" href="<?php echo root ?>/mesCommandes.php/exportCSV?idUtilisateur=<?php echo $i_idUtilisateur?>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "&id_camp=".$i_idCampagne;
}
?>
">Exporter au format CSV (Excel)</a></p>
<p><a class="action_navigation" href="<?php echo root ?>/mesCommandes.php/exportPDF?idUtilisateur=<?php echo $i_idUtilisateur?>
<?php echo "&id_camp=".$i_idCampagne;?>">Exporter au format PDF</a></p>
<?php
} else {
?>
<p class="message">Vous n'avez pas de commande en cours.</p>
<?php
}
?>
