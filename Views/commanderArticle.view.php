<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Commander un article</h1>

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
coucou
		<?php  echo $i_idRayon;
		/* Affiche ou non le formulaire */
		if ($b_etat == 1) {
			?>
                <form method="post" action="<?php echo root ?>/commanderArticle.php/commanderArticleModifier?idRayon=<?php echo $i_idRayon?>">
				<?php
		}
	?>
		<table id="t_article">
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
        ?> avant boucle <?php
        foreach($to_commande as $o_produit) {
            ?> apres boucle rayonprodiut <?php echo $o_produit['id_rayon']; ?> rayon donne <?php echo $i_idRayon ;
            if($o_produit['id_rayon']==$i_idRayon){	?>
bon produit
			<tr class="ligne_article<?php echo $i_numLigne ?>">
			<td><?php echo $o_produit['nom'] ?></td>
			<!--
			<td><?php echo $o_produit['description_courte'] ?></td>
			<td><?php echo $o_produit['description_longue'] ?></td>
			--> 
			<td class="centrer"><?php echo $o_produit['poids_paquet_fournisseur'] ?><?php echo $o_produit['unite'] ?></td>
			<!-- <td class="centrer"><?php echo $o_produit['unite'] ?></td> -->
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
					<td class="centrer"><a href="<?php echo root ?>/commanderArticle.php/commanderArticleSupprimer?id_article=<?php echo $o_produit['id_article']?>&idRayon=<?php echo $i_idRayon?>">supprimer l'article</a>
					<?php
			}
		?>
			</tr>
			<?php
			$i_numLigne = ($i_numLigne + 1) % 2;
	}
}
	?>  
		<tr>
		<th colspan=9>Montant Total = </th>
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
		<?php
} else { 
	if ($to_rayon != 0 and $to_rayon != array()) {
		?>
		<ul>
			<?php 
			foreach($to_rayon as $o_rayon) { 
				?>
					<li> <a href="<?php echo root ?>/commanderArticle.php/commanderArticle?idRayon=<?php echo $o_rayon['id']?>"><?php echo $o_rayon['nom'] ?></a></li>
					<?php
			}
	} else {
	?>
		<p>Vous n'avez pas de commande en cours.</p>
		<?php
}
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
