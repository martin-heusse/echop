<!-- affiche l'intreface de commande pour l'utilisateur -->
<p><a class="action_navigation" href="<?php echo root ?>/commanderArticle.php/afficherRayon">Retour aux rayons</a></p>

<h1>Commander des articles</h1>


<?php 
function formatPrix($prix){
    return number_format($prix, 2, '.', '');
}

function boutonValidation($_b_etat, $_cat_courante){
        if ($_b_etat == 1) {
?>
                <input class="input_valider" name="cat_<?php echo $_cat_courante;?>" type="submit" value="Mettre à jour les quantités"/>
                </form>
<?php
        }
}
?>

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

/* Nom du Rayon */
?>
    <h2><?php echo $s_Rayon?></h2>

<?php
if ($to_commande != null and $to_commande != array()) {
    /* si aucun article est en vente, on affiche rien */

    $i_nbreArticleRayon = 0;
    $i_nbreEnVente = 0;
    foreach($to_commande as $o_produit){
        $i_nbreArticleRayon += $o_produit['nbre_article'];
        if ($o_produit['en_vente'] == 1 && $o_produit['id_rayon']==$i_idRayon) {
            $i_nbreEnVente ++;
        }
    } 
    if ($i_nbreArticleRayon !=0 && $i_nbreEnVente != 0){

        /* Affiche ou non le formulaire (affichage uniquement si la campagne est 
            * ouverte) */
        if ($b_etat == 1) {
?>
                <form method="post" action="<?php echo root ?>/commanderArticle.php/commanderArticleModifier?idRayon=<?php echo $i_idRayon?>">
<?php
        }
?>
        <p>
        <span class="cat_bouton cacher_tout">Cacher tout </span> |
        <span class="cat_bouton montrer_tout">Montrer tout</span> 
        </p>
        <table id="t_article">
        <tr>
        <th>Produit</th>
        <th>Description</th>
        <th>Poids paquet <font size="-1"> fournisseur</font></th>
        <th><font size="-1">Nb paq. / colis</font></th>
        <th>Prix TTC</th>
        <th>Prix TTC unitaire</th>
        <th><font size="-1">Poids unitaire à commander</font></th>   
        <th><font size="-2">Quantité mini. à commander</font></th>
        <th>Quantité</th>
        <th><font size="-2">Quantité commandée</font></th>
        <th>Total TTC</th>
<?php
        $i_colspanCat = 11;
        /* Affiche ou non la colonne de suppression */
        if ($b_etat == 1) {
            $i_colspanCat++;
?>
                <th>Suppr. article</th>
<?php
        }
?>
        </tr>
<?php 
        $i_numLigne = 0;
        $prev_cat=NULL;
        $next_cat_a_afficher=-1;
        /* l'affichage des produits se fait par catégorie */
        foreach ($to_categorie as $o_categorie) {
            $i_nbreArticleCategorie = 0;
            foreach($to_commande as $o_produit) {
                if(($o_produit['categorie']) == ($o_categorie['nom']) && $o_produit['id_rayon']==$i_idRayon && $o_produit['en_vente'] == 1){
                    $i_nbreArticleCategorie++;
                }
            }
            /* on affiche la catégorie uniquement si elle contient des produits 
             * */
            if ($i_nbreArticleCategorie != 0){
            
            //Si la categorie à afficher est mentionnée, alors on affichera aussi la suivante
            if($cat_a_afficher!=NULL&&$prev_cat==$cat_a_afficher){$next_cat_a_afficher=$o_categorie['id'];}
            $prev_cat=$o_categorie['id'];
?>
    <tr><td colspan=<?php echo $i_colspanCat ?>>
        <a name=cat_<?php echo $o_categorie['id'] ;?>>
        <span class="cat"><?php echo $o_categorie['nom'] ?></span>
<!--gère le déroulement des catégories-->
        <span class="cat_bouton cacher_<?php echo $o_categorie['id'] ?>">Cacher</span> 
        <span class="cat_bouton montrer_<?php echo $o_categorie['id'] ?>">Montrer</span> 
    </td></tr>

<?php
                /* Avant l'affichage, on vérifie que le produit appartient au 
                 * bon rayon, la bonne catégorie et qu'il est en vente */
                foreach($to_commande as $o_produit) {
                    if($o_produit['id_rayon']==$i_idRayon && $o_produit['categorie'] == $o_categorie['nom'] && $o_produit['en_vente'] == 1){ 	?>
            <tr class="ligne_article<?php echo $i_numLigne ?> cat_<?php echo $o_categorie['id'] ?>">
            <td title="Produit" class="centrer"><?php echo $o_produit['nom'] ?></td>
            <td class="centrer" title="Description"><?php echo $o_produit['description_courte'] ?> <BR /><font size="-2"> <?php echo $o_produit['description_longue'] ?></font></td>
            <td class="centrer" title="Poids du paquet du fournisseur"><?php echo $o_produit['poids_paquet_fournisseur'] ?><?php echo $o_produit['unite'] ?></td>
            <td class="centrer" title="Nombre de paquets par colis"><?php echo $o_produit['nb_paquet_colis'] ?></td>
            <td class="centrer" title="Prix TTC"><?php echo formatPrix($o_produit['prix_ttc']) ?>&euro;</td>
            <td class="centrer" title="Prix TTC unitaire"><?php if(strcmp($o_produit['unite'],"g")) {echo formatPrix($o_produit['prix_unitaire'])."&euro;/".$o_produit['unite'] ;}
                else {$prix100g=formatPrix(100*$o_produit['prix_unitaire']) ; echo $prix100g."&euro;/100".$o_produit['unite'] ; }   
            ?></td>
            <td class="centrer" title="Poids unitaire qu'on peut commander"><?php echo $o_produit['poids_paquet_client'] ?><?php echo $o_produit['unite'] ?></td>
            <td class="centrer" title="Quantité minimale qu'on peut commander"><?php echo $o_produit['seuil_min'] ?></td>
<?php
                        /* Bloquer ou autoriser la modification de la quantité */
                        if ($b_etat == 1) {
?>
                    <td title="Quantité">
            <center><input class="input_quantite" type="text" name="quantite[<?php echo $o_produit['id_article']?>]" value="<?php echo $o_produit['quantite']?> " onclick="select()"/></center>
                    <input  type="hidden" name="prev_quantite[<?php echo $o_produit['id_article']?>]" value="<?php echo $o_produit['quantite']?> "/>
                    </td>
<?php
                        } else {
?>
                    <td class="centrer"><?php echo $o_produit['quantite'] ?></td>
<?php
                        }
?>
            <td class="centrer col_coloree" title="Quantité totale commandée"><?php echo $o_produit['quantite_totale'] ?><?php echo $o_produit['unite'] ?></td>
            <td class="centrer col_coloree" title="Total TTC"><?php echo formatPrix($o_produit['total_ttc']) ?>&euro;</td>
<?php
                    /* Affiche ou non le lien de suppression */
                    if ($b_etat == 1) {
?>
                    <td class="centrer"><a href="<?php echo root ?>/commanderArticle.php/commanderArticleSupprimer?id_article=<?php echo $o_produit['id_article']?>&idRayon=<?php echo $i_idRayon?>">Suppr. l'article</a>
<?php
                    }
?>
            </tr>
<?php
                    $i_numLigne = ($i_numLigne + 1) % 2;
                    }
                } 
            echo "<tr class='ligne_article$i_numLigne cat_".$o_categorie['id']."' ><td colspan=12>" ;
            boutonValidation($b_etat,$o_categorie['id']); echo "</td></tr>"; 
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
        boutonValidation($b_etat, NULL);
    } else {
?>
    <p class="message">Aucun article n'est en vente dans ce rayon.</p>
<?php
    }
} else { 
?>
    <p class="message">Vous n'avez pas de commande en cours.</p>
<?php 
}

?>
<?php
foreach ($to_categorie as $o_categorie) {
    /* script qui permet le déroulement par catégorie */
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


<script type="text/javascript">
cacher_tout=function () {
    $(".ligne_article0").hide(0);
    $(".ligne_article1").hide(0);
}
cacher_onLoad=function(){
    cacher_tout();
    $(".cat_<?php echo $cat_a_afficher ?>").show("slow");
    $(".cat_<?php echo $next_cat_a_afficher ?>").show("slow");
    location.hash='#cat_<?php echo $cat_a_afficher ; ?>';
}

window.onload = cacher_onLoad;
$(".cacher_tout").click(function () {cacher_tout();});
$(".montrer_tout").click(function () {
    $(".ligne_article0").show(0);
    $(".ligne_article1").show(0);
});
</script>
