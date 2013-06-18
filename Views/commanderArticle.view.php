<p><a class="action_navigation" href="<?php echo root ?>/commanderArticle.php/afficherRayon">Retour aux rayons</a></p>

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
    /* si aucun article est en vente, on affiche rien */

    $i_nbreArticleRayon = 0;
    foreach($to_commande as $o_produit){
        $i_nbreArticleRayon += $o_produit['nbre_article'];
    } 
    if ($i_nbreArticleRayon !=0){

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
<?php
        $i_colspanCat = 11;
        /* Affiche ou non la colonne de suppression */
        if ($b_etat == 1) {
            $i_colspanCat++;
?>
                <th>Suppression d'un article</th>
<?php
        }
?>
        </tr>
<?php 
        $i_numLigne = 0;
        foreach ($to_categorie as $o_categorie) {
            $i_nbreArticleCategorie = 0;
            foreach($to_commande as $o_produit) {
                if(($o_produit['categorie']) == ($o_categorie['nom']) && $o_produit['id_rayon']==$i_idRayon){
                    $i_nbreArticleCategorie++;
                }
            }
            if ($i_nbreArticleCategorie != 0){
?>
    <tr><td colspan=<?php echo $i_colspanCat ?>>
        <span class="cat"><?php echo $o_categorie['nom'] ?></span>
        <span class="cat_bouton cacher_<?php echo $o_categorie['id'] ?>">[Cacher]</span> 
        <span class="cat_bouton montrer_<?php echo $o_categorie['id'] ?>">[Montrer]</span> 
    </td></tr>
<br/>
<?php
                foreach($to_commande as $o_produit) {
                    /*Afficher la catégorie TODO*/
                    if($o_produit['id_rayon']==$i_idRayon && $o_produit['categorie'] == $o_categorie['nom'] && $o_produit['en_vente'] == 1){ 	?>
            <tr class="ligne_article<?php echo $i_numLigne ?> cat_<?php echo $o_categorie['id'] ?>">
            <td><?php echo $o_produit['nom'] ?></td>
            <td class="center" title="<?php echo $o_produit['description_longue'] ?>"><?php echo $o_produit['description_courte'] ?></td>
            <!--
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
            } 
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

    } else {
?>
    Aucun article n'est en vente dans ce rayon.
<?php
    }
} else { 
?>
    <p>Vous n'avez pas de commande en cours.</p>
<?php 
}

?>
<?php
foreach ($to_categorie as $o_categorie) {
?>
    <script type="text/javascript">
    $(".cacher_<?php echo $o_categorie['id'] ?>").click(function () {
        $(".cat_<?php echo $o_categorie['id'] ?>").hide("slow");
    });
    </script>
    <script type="text/javascript">
    $(".montrer_<?php echo $o_categorie['id'] ?>").click(function () {
        $(".cat_<?php echo $o_categorie['id'] ?>").show("slow");
    });
    </script>
<?php
}
?>
