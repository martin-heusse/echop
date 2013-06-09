<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Mes Commandes</h1>
<?php
if ($to_commande != null) {
?>
<!--
<form method="post" action="commande.php/mesCommandes">
-->
<table id="t_article">
<tr>
    <th>Produit</th>
    <!--
    <th>Description courte</th>
    <th>Description longue</th>
     -->
    <th>Poids du paquet du fournisseur</th>
    <th>Unite</th>
    <th>Nombre de paquets par colis</th>
    <th>Prix TTC</th>
    <th>Prix TTC unitaire (au kilo/litre)</th>
    <th>Poids unitaire que le client peut commander</th>   
    <th>Quantité minimale que l'on peut commander</th>
    <th>Quantité</th>
    <th>Quantité totale commandée</th>
    <th>Total TTC</th>
</tr>
<?php 
    foreach($to_commande as $o_produit) {
?>
  <tr> 
    <td><?php echo $o_produit['nom'] ?></td>
    <!--
    <td><?php echo $o_produit['description_courte'] ?></td>
    <td><?php echo $o_produit['description_longue'] ?></td>
    --> 
    <td><?php echo $o_produit['poids_paquet_fournisseur'] ?></td>
    <td><?php echo $o_produit['unite'] ?></td>
    <td><?php echo $o_produit['nb_paquet_colis'] ?></td>
    <td><?php echo $o_produit['prix_ttc'] ?></td>
    <td><?php echo $o_produit['prix_unitaire'] ?></td>
    <td><?php echo $o_produit['poids_paquet_client'] ?></td>
    <td><?php echo $o_produit['seuil_min'] ?></td>
    <td><input type="text" name="quantite[<?php echo $o_produit['id_article']?>" value="<?php echo $o_produit['quantite'] ?>"/></td>
    <td><?php echo $o_produit['quantite_totale'] ?></td>
    <td><?php echo $o_produit['total_ttc'] ?></td>
</tr>
<?php
   }  
<!--
<input type="submit" value="Modifier"/>
</form>
-->
?>
</table>
<?php
} else {
?>
<p>Vous n'avez pas de commande en cours</p>
<?php
}
?>
<!--
<script type="text/javascript">
function calculPoidsTotal(){
    var poidsTotal = 0.0;
    var test = event.srcElement;
    // quantité est la 10eme colonne
    document.write(test);
    var quantite = parseFloat(document.getElementById("t_article").rows[this.rowIndex].cells[10].innerHTML); 
} 
</script>
-->
