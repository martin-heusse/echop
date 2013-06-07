<h1>Mes Commandes</h1>
<?php
if ($to_commande != null) {
?>
<table>
<tr>
    <th>Nom</th>
    <th>Poids paquet fournisseur</th>
    <th>Unite</th>
    <th>nb paquet/colis</th>
    <th>Description courte</th>
    <th>Description longue</th>
    <th>Quantité</th>
</tr>
<?php 
foreach($to_commande as $o_produit) {
?>
  <tr> 
    <td><?php echo $o_produit['nom'] ?></td>
    <td><?php echo $o_produit['poids_paquet_fournisseur'] ?></td>
    <td><?php echo $o_produit['unite'] ?></td>
    <td><?php echo $o_produit['nb_paquet_colis'] ?></td>
    <td><?php echo $o_produit['description_courte'] ?></td>
    <td><?php echo $o_produit['description_longue'] ?></td>
    <td><?php echo $o_produit['quantite'] ?></td>
</tr>
<?php
}
?>
</table>
<?php
} else {
?>
<p> Vous n'avez pas de commande en cours </p>
<?php
}
?>