<!-- interface de gestion des articles -->
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
<p><a class="action_navigation" href="<?php echo root ?>/campagne.php/gererCampagne">Retour à la gestion des campagnes</a></p>
<?php
} else {
?>
<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>
<?php
}
?>

<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
    <span class="historique">[Historique de la campagne n°<?php echo $i_idCampagne ?>]</span>
<?php
}
?>

<p>
<?php
if(isset($i_erreur)){
    if($i_erreur==0){
?>
<p class="succes">Vos articles ont été modifiés !</p>
<?php
    }
    if($i_erreur==1){
?>
<p class="erreur">Erreur de saisie, les articles n'ont pas été modifiés !</p>
<?php
    }
}
?>
</p>

<h1>Gérer tous les articles</h1>



<!-- Affichage de la liste des rayons -->
<?php
foreach($to_rayon as $o_rayon){
?>
    <a <?php if($o_rayon['id']==$i_idRayon){ echo "style=\"background-color: grey;\"";} ?> 
       href="<?php echo root; ?>/article.php/afficherArticle?i_idRayon=<?php echo $o_rayon['id']; ?>
<?php
    /* Si navigation dans l'historique */
    if ($b_historique == 1) {
        echo "&idOldCampagne=".$i_idCampagne;
    }
?>
"><?php echo $o_rayon['nom']; ?></a>&nbsp;
<?php
}
?>
    <hr>
<?php
if(isset($s_message)){
?>
    <p><?php echo $s_message; ?></p>
<?php
    return;
}
?>
<p>
<?php
/* Si pas navigation dans l'historique */
if ($b_historique == 0) {
?>
    <a href="<?php echo root ?>/article.php/afficherCreerArticle?i_idRayon=<?php echo $i_idRayon; ?>">Créer un article</a> | 
<?php
}

/* Tout cocher ou tout décocher */
?>
    <a href="<?php echo root ?>/article.php/cocherArticleVente?i_idRayon=<?php echo $i_idRayon ?>">Mettre en vente tous les articles</a> | 
    <a href="<?php echo root ?>/article.php/decocherArticleVente?i_idRayon=<?php echo $i_idRayon ?>">Retirer de la vente tous les articles</a>
</p>

<?php
/* Si pas navigation dans l'historique */
if ($b_historique == 0) {
?>
    <span>Marge : <?php echo $marge; ?>&nbsp;%</span>
<?php
}
?>

<p>
<span class="cat_bouton cacher_tout">[Cacher tout]</span> 
<span class="cat_bouton montrer_tout">[Montrer tout]</span> 
</p>

<?php
if($to_descriptionArticle == array()){ 
?>
    <p><?php echo "Pas d'article pour ce rayon !"; ?></p>
<?php 
    return;
}
?>

<!-- Création d'un formulaire englobant tout le tableau -->
<form method="post" action="<?php echo root ?>/article.php/modifierArticle
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "?idOldCampagne=".$i_idCampagne;
}
?>
">

<!-- En variable cachée id_rayon -->
<input type="hidden" name="i_idRayon" value="<?php echo $i_idRayon ?>"/>


<table>
    <thead> <!-- En-tête du tableau -->
        <tr class="tab_article">
            <th>Mettre en vente auprès du client</th>
            <th>Produit</th>
            <th>Description courte</th>
            <th>Description longue</th>
            <th>Unité</th>
            <th>Nombre de paquets par colis </th>
            <th>Poids du paquet fournisseur</th>
            <th>Poids du paquet client</th>
            <th>Seuil min</th>
            <th>TVA</th>
<?php
foreach($to_fournisseur as $o_fournisseur){
    /* boucle pour afficher le nom de tous les fournisseurs */
?>
            <th><?php echo $o_fournisseur['nom_fournisseur']; ?></th>
            <!-- En variable cachée id_fournisseur -->
            <input type="hidden" name="id_Fournisseur_rayon[]" value="<?php echo $o_fournisseur['id_fournisseur']; ?>"/>
<?php
}
?>
            <!-- colonne informative il y a des arrondis -->
            <th>Prix client TTC </th>
            <!-- colonne informative -->
            <th>Prix client unitaire TTC </th>
         </tr>
    </thead>
    <tbody> <!-- Corps du tableau -->
<?php
        $i_colspanCat = 10;
?>
<?php
/* $i_numLigne représente pair ou impair pour l'affichage une ligne sur deux */
$i_numLigne = 0;

/* AJOUT catégorie*/
foreach ($to_categorie as $o_categorie) {
    $i_nbreArticleCategorie = 0;
    foreach($to_descriptionArticle as $o_descriptionArticle) {
        if ($o_descriptionArticle['id_categorie'] == $o_categorie['id']) { 
            $i_nbreArticleCategorie++;
        }
    }
    if ($i_nbreArticleCategorie != 0) {
?>
    <tr><td colspan=<?php echo $i_colspanCat ?>>
        <span class="cat"><?php echo $o_categorie['nom'] ?></span>
        <span class="cat_bouton cacher_<?php echo $o_categorie['id'] ?>">[Cacher]</span> 
        <span class="cat_bouton montrer_<?php echo $o_categorie['id'] ?>">[Montrer]</span> 
    </td></tr>
<?php
        foreach ($to_descriptionArticle as $o_descriptionArticle) {
            /* AJOUT condition pour la catégorie */
            if ($o_descriptionArticle['id_categorie'] == $o_categorie['id']) { 
                // boucle pour affcher tous les produits
                $i_idArticleCampagne = $o_descriptionArticle['id_article_campagne'];
                if ($o_descriptionArticle['en_vente']) {
                    ?>
            <tr class="ligne_article<?php echo $i_numLigne ?>1 cat_<?php echo $o_categorie['id'] ?>">
<?php 
                } else {
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>2 cat_<?php echo $o_categorie['id'] ?>">
<?php
                }
?>
                <!-- En variable cachée id_article_campagne -->
                <input type="hidden" name="id_article_campagne[]" value="<?php echo $i_idArticleCampagne ?>"/>
                <!-- Mettre en vente -->
                <td class="center tab_article"  title="Mettre en vente auprès du client">
                    <select name="en_vente[]">
                        <option value="1" 
                                <?php if($o_descriptionArticle['en_vente'] == '1'){echo 'selected="true"';}?>
                         >En vente</option>
                        <option value="0" 
                                <?php if($o_descriptionArticle['en_vente'] == '0'){echo 'selected="true"';}?>
                        >Pas en vente</option>
                    </select>
                </td>
                <!-- Nom du produit -->
                <td class="center tab_article" title="Produit : Le nom du produit">
                    <input class="input_quantite" 
                           type="text" 
                           name="nom_produit[]" 
                           value="<?php echo $o_descriptionArticle['nom']?>" 
                           required 
                    />
                </td>
                <!-- Description courte -->
                <td class="center tab_article" title="Description courte : présentation brève du produit" >
                    <input class="input_quantite" 
                           type="text" 
                           name="description_courte[]" 
                           value="<?php echo $o_descriptionArticle['description_courte']?>" 
                           required 
                     />
                </td>
                <!--Description longue -->
                <td class="center tab_article" title="Description longue : présentation plus détaillée du produit">
                    <input class="input_quantite" 
                       type="text" name="description_longue[]" 
                       value="<?php echo $o_descriptionArticle['description_longue']?>" 
                       required 
                     />
                 </td>
                <!-- Unité -->
                <td class="center tab_article" title="Unite" ><select name="id_unite[]">
<?php
                foreach($to_unite as $o_unite){
                    $i_idUnite = $o_unite['id'];
                    $f_valeurUnite = $o_unite['valeur'];
                    $i_idUniteChoisi = $o_descriptionArticle['id_unite_choisi'];
?>
                    <option value="<?php echo $i_idUnite ?>" 
                           <?php if($i_idUnite==$i_idUniteChoisi){echo 'selected="true"';} ?>
                    > <?php echo $f_valeurUnite ?></option>
<?php
                }
?>
                </select></td>
                <!-- Nombre de paquets par colis fournisseur -->
                <td class="center tab_article" title="Nombre de paquets par colis">
                   <input class="input_quantite" 
                          type="text" 
                          name="nb_paquet_colis[]" 
                          value="<?php echo $o_descriptionArticle['nb_paquet_colis']?>" 
                          required 
                    />
                    <br /> paquet/colis fournisseur
                </td>
                <!-- Poids du paquet fournisseur -->
                <td class="center tab_article" title="Poids du paquet fournisseur" >
                   <input class="input_quantite" 
                          type="text" 
                          name="poids_paquet_fournisseur[]" 
                          value="<?php echo $o_descriptionArticle['poids_paquet_fournisseur']?>" 
                          required 
                    />
                    <br />&nbsp;<?php echo $o_descriptionArticle['valeur_unite_choisi'] ?>
                </td>
                <!-- Poids du paquet client -->
                <td class="center tab_article" title="Poids du paquet client">
                   <input class="input_quantite" 
                          type="text" 
                          name="poids_paquet_client[]" 
                          value="<?php echo $o_descriptionArticle['poids_paquet_client'] ?>" 
                          required 
                    />
                    <br />&nbsp;<?php echo $o_descriptionArticle['valeur_unite_choisi'] ?>
                </td>
                <!-- Seuil min -->
                <td class="center tab_article" title="Seuil min que peut choisir le client">
                     <input class="input_quantite" 
                            type="text" name="seuil_min[]" 
                            value="<?php echo $o_descriptionArticle['seuil_min'] ?>" 
                            required 
                     />
                </td>
                <!-- TVA -->
                <td aclass="center tab_article";;lign="center" title="TVA" ><select name="id_tva[]">
<?php
                foreach($to_tva as $o_tva){
                    $i_idTva = $o_tva['id'];
                    $f_valeurTva = $o_tva['valeur'];
                    $i_idTvaChoisi = $o_descriptionArticle['id_tva_choisi'];
?>
                    <option value="<?php echo $i_idTva ?>" <?php if($i_idTva==$i_idTvaChoisi){echo 'selected="true"';} ?>> 
                       <?php echo $f_valeurTva ?>&nbsp;%
                    </option>
<?php
                }
?>
                </select></td>
                <!-- Boucle pour afficher les fournisseurs disponibles du rayon-->
<?php
                $i_idFournisseurChoisi = $o_descriptionArticle['id_fournisseur_choisi'];
                foreach($to_fournisseur as $o_fournisseur){
                    $i_idFournisseur = $o_fournisseur['id_fournisseur'];
                    if(isset($o_descriptionArticle[$i_idFournisseur]['prix_fournisseur'])){
                        $f_prixFournisseur = $o_descriptionArticle[$i_idFournisseur]['prix_fournisseur'];
                        $b_prixTtcHt = $o_descriptionArticle[$i_idFournisseur]['prix_ttc_ht'];
                        $b_ventePaquetUnite = $o_descriptionArticle[$i_idFournisseur]['vente_paquet_unite'];
?>
                <td class="center tab_article" title="Fournisseur : <?php echo $o_fournisseur['nom_fournisseur']; ?>">
                    <table class="tab_tab_article">
                        <th>Code</th>
                        <th>Prix donnée par le fournisseur</th>
                        <th>Prix TTC</th>
                        <th>Choisir</th>
                        <tr>
                            <td align="center"> <!-- code -->
                                <input class="input_quantite" 
                                       type="text" 
                                       name="code[<?php echo $i_idFournisseur ?>][]" 
                                       value="<?php echo $o_descriptionArticle[$i_idFournisseur]['code']?>" 
                                />
                            </td>
                            <td align="center"> <!-- prix donnée par le fournisseur -->
                                <!-- montant -->
                                montant : <input class="input_quantite" 
                                                 type="text" 
                                                 name="montant[<?php echo $i_idFournisseur ?>][]"
                                                 value="<?php echo $f_prixFournisseur; ?>"
                                          />
                                          <br />&nbsp;&euro; / &nbsp;
                                <!-- unite ou paquet -->
                                <select name="vente_paquet_unite[<?php echo $i_idFournisseur ?>][]">
                                    <option value="1" <?php if($b_ventePaquetUnite == '1'){echo 'selected="true"';} ?>>
                                      paquet
                                    </option>
                                    <option value="0" <?php if($b_ventePaquetUnite == '0'){echo 'selected="true"';} ?>>
                                       <?php echo $o_descriptionArticle['valeur_unite_choisi'] ?>
                                    </option>
                                </select>
                                <!-- HT ou TTC -->
                                <select name="prix_ttc_ht[<?php echo $i_idFournisseur ?>][]">
                                    <option value="1" <?php if($b_prixTtcHt == '1'){echo 'selected="true"';} ?>>TTC</option>
                                    <option value="0" <?php if($b_prixTtcHt == '0'){echo 'selected="true"';} ?>>HT</option>
                                </select>
                            </td>
                            <td align="center"> <!-- Prix TTC -->
                                <input class="input_quantite" 
                                       type="text"
                                       value="<?php echo $o_descriptionArticle[$i_idFournisseur]['prix_ttc'] ?>"
                                       disabled
                                 />
                                 <br />&nbsp;&euro;/ paquet fournisseur
                            </td>
                            <td align="center"> <!-- Choisir -->
                                <input type="radio" 
                                       name="id_fournisseur_choisi[<?php echo $i_idArticleCampagne ?>]" 
                                       value="<?php echo $i_idFournisseur ?>"  
                                       <?php if($i_idFournisseur==$i_idFournisseurChoisi){echo 'checked="true"';} ?>
                                 />
                           </td>
                        </tr>
                    </table>
                 </td>
<?php 
                    } else {
?>
                            <td class="center tab_article" title="Fournisseur : <?php echo $o_fournisseur['nom_fournisseur']; ?>" style="visibility:hidden;";>
                    <table class="tab_tab_article">
                        <th>Code</th>
                        <th>Prix donnée par le fournisseur</th>
                        <th>Prix TTC</th>
                        <th>Choisir</th>
                        <tr>
                            <td align="center"> <!-- code -->
                                <input class="input_quantite" 
                                       type="text" 
                                       name="code[<?php echo $i_idFournisseur ?>][]" 
                                       value="<?php echo $o_descriptionArticle[$i_idFournisseur]['code']?>" 
                                />
                            </td>
                            <td align="center"> <!-- prix donnée par le fournisseur -->
                                <!-- montant -->
                                montant : <input class="input_quantite" 
                                                 type="text" 
                                                 name="montant[<?php echo $i_idFournisseur ?>][]"
                                                 value="<?php echo $f_prixFournisseur; ?>"
                                          />
                                          <br />&nbsp;&euro; / &nbsp;
                                <!-- unite ou paquet -->
                                <select name="vente_paquet_unite[<?php echo $i_idFournisseur ?>][]">
                                    <option value="1" <?php if($b_ventePaquetUnite == '1'){echo 'selected="true"';} ?>>
                                      paquet
                                    </option>
                                    <option value="0" <?php if($b_ventePaquetUnite == '0'){echo 'selected="true"';} ?>>
                                       <?php echo $o_descriptionArticle['valeur_unite_choisi'] ?>
                                    </option>
                                </select>
                                <!-- HT ou TTC -->
                                <select name="prix_ttc_ht[<?php echo $i_idFournisseur ?>][]">
                                    <option value="1" <?php if($b_prixTtcHt == '1'){echo 'selected="true"';} ?>>TTC</option>
                                    <option value="0" <?php if($b_prixTtcHt == '0'){echo 'selected="true"';} ?>>HT</option>
                                </select>
                            </td>
                            <td align="center"> <!-- Prix TTC -->
                                <input class="input_quantite" 
                                       type="text"
                                       value="<?php echo $o_descriptionArticle[$i_idFournisseur]['prix_ttc'] ?>"
                                       disabled
                                 />
                                 <br />&nbsp;&euro;/ paquet fournisseur
                            </td>
                            <td align="center"> <!-- Choisir -->
                                <input type="radio" 
                                       name="id_fournisseur_choisi[<?php echo $i_idArticleCampagne ?>]" 
                                       value="<?php echo $i_idFournisseur ?>"  
                                       <?php if($i_idFournisseur==$i_idFournisseurChoisi){echo 'checked="true"';} ?>
                                 />
                           </td>
                        </tr>
                    </table>
                 </td>

<?php
                    }
                }
?>
                <!-- Prix client TTC  -->
                <td class="center tab_article" title="Prix client TTC">
                    <input class="input_quantite" 
                           type="text" 
                           value="<?php echo $o_descriptionArticle['prix_echoppe'] ?>"
                           disabled
                    />
                    <br />&nbsp;&euro;/paquet fournisseur
                </td>
                <!-- Prix client unitaire TTC -->
                <td class="center tab_article" title="Prix client unitaire TTC">
                  <input class="input_quantite" 
                         value="<?php echo $o_descriptionArticle['prix_echoppe_unite'] ?>"
                         disabled
                  />
                  <br />&nbsp;&euro;/<?php echo $o_descriptionArticle['valeur_unite_choisi'] ?>
                </td>
                <td><input type="submit" class="input_valider" name=submit_<?php echo $i_idArticleCampagne ?> value="MàJ"/>
</td>
          </tr>
<?php
                $i_numLigne = ($i_numLigne + 1) % 2;
            }
        }
    }
}
?>
        </tbody>
</table>
</form>
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

<script type="text/javascript">
cacher_tout=function () {
    $(".ligne_article01").hide(0);
    $(".ligne_article11").hide(0);
    $(".ligne_article12").hide(0);
    $(".ligne_article02").hide(0);
}
cacher_onLoad=function(){
    cacher_tout();
}
window.onload = cacher_onLoad;
$(".cacher_tout").click(function () {cacher_tout();});
$(".montrer_tout").click(function () {
    $(".ligne_article01").show(0);
    $(".ligne_article11").show(0);
    $(".ligne_article12").show(0);
    $(".ligne_article02").show(0);
});
</script>

