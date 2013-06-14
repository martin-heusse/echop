<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Gérer tous les articles</h1>

<!-- Création d'un formulaire englobant tout le tableau -->
<form method="post" action="<?php echo root ?>/article.php/modifierArticle">

<p>La liste des actions :
<button><a href="<?php echo root ?>/article.php/afficherCreerArticle">Créer un article</a></button>
<input align="middle" type="submit" class="input_valider" value="Mettre à jour les articles"/>
</p>

<table style="font-size:10px;">
    <thead> <!-- En-tête du tableau -->
        <tr>
            <th>Produit</th>
            <th>Description courte</th>
            <th>Description longue</th>
            <th>Poids du paquet fournisseur</th>
            <th>Poids du paquet client</th>
            <th>Nombre de paquets par colis</th>
            <th>Seuil min</th>
<?php
foreach($to_fournisseur as $o_fournisseur){
//boucle pour afficher le nom de tous les fournisseurs
?>
            <th width=10><?php echo $o_fournisseur['nom'] ?></th>
<?php
}
?>
            <th>TVA</th>
            <!-- colonne informative attention aux arrondis -->
            <th>Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client</th>
            <!-- colonne informative -->
            <th>Prix TTC rapporté à l'unité echoppe</th>
         </tr>
    </thead>
    <tbody> <!-- Corps du tableau -->
<?php
foreach ($to_descriptionArticle as $o_descriptionArticle) {
// boucle pour affcher tous les produits
$i_idArticleCampagne = $o_descriptionArticle['id']
?>
            <tr>
                <!-- En variable cachée id_article_campagne -->
                <input type="hidden" name="id_article_campagne[]" value="<?php echo $i_idArticleCampagne ?>"/>
                <!-- Nom du produit -->
                <td align="center" title="Produit : Le nom du produit"><?php echo $o_descriptionArticle['nom'] ?></td>
                <!-- Description courte -->
                <td align="center" title="Description courte : présentation brève du produit" class="input_quantite"><?php echo $o_descriptionArticle['description_courte'] ?></td>
                <!--Description longue -->
                <td align="center" title="Description longue : présentation plus détaillée du produit"><?php echo $o_descriptionArticle['description_longue'] ?></td>
                <!-- Poids du paquet fournisseur -->
                <td align="center" title="Poids du paquet fournisseur" ><?php echo $o_descriptionArticle['poids_paquet_fournisseur'] ?>&nbsp;<?php echo $o_descriptionArticle['unite'] ?></td>
                <!-- Poids du paquet client -->
                <td align="center" title="Poids du paquet client"><div><input class="input_quantite" type="text" name="poids_paquet_client[]" value="<?php echo $o_descriptionArticle['poids_paquet_client'] ?>"/>&nbsp;<?php echo $o_descriptionArticle['unite'] ?></div></td>
                <!-- Nombre de paquets par colis fournisseur -->
                <td align="center" title="Nombre de paquets par colis"><?php echo $o_descriptionArticle['nb_paquet_colis'] ?></td>
                <!-- Seuil min -->
                <td align="center" title="Seuil min que peut choisir le client"><input class="input_quantite" type="text" name="seuil_min[]" value="<?php echo $o_descriptionArticle['seuil_min'] ?>"/></td>

                <!-- Boucle pour afficher les fournisseurs disponibles -->
<?php
    foreach($to_fournisseur as $o_fournisseur){
        $id = $o_fournisseur['id'];
        if(isset($o_descriptionArticle[$id])){
            if($o_descriptionArticle[$id]['prix_ht'] == ""){
                $prix_fournisseur = $o_descriptionArticle[$id]['prix_ttc'];
             } else {
                $prix_fournisseur = $o_descriptionArticle[$id]['prix_ht'];
            }
?>
                <td title="Fournisseur : <?php echo $o_fournisseur['nom']; ?>">
                    <table style="width:100%; font-size:9px;">
                        <th>code</th>
                        <th>prix</th>
                        <th style="height:1em;">prix ttc</th>
                        <th>Choisir</th>
                        <tr>
                            <td><?php echo $o_descriptionArticle[$id]['code'] ?></td>
                            <td><?php echo $prix_fournisseur ?>&nbsp;&euro;</td>
                            <td><?php echo $o_descriptionArticle[$id]['prix_ttc'] ?>&nbsp;&euro;</td>
                            <td><input type="radio" name="fournisseur_choisi[]" value="<?php echo $id ?>"  <?php if($id==$o_descriptionArticle['id_fournisseur']){echo 'checked="true"';} ?>></td>
                        </tr>
                    </table>
                 </td>
<?php
        } else {
?>
                <td align="center" title="Fournisseur : <?php echo $o_fournisseur['nom']; ?>"> </td>
<?php
        }
    }
?>
                <!-- TVA -->
                <td align="center" title="TVA" ><select name="tva[]">
<?php
    foreach($to_tva as $o_tva){
?>
                    <option value="<?php echo $o_tva['id'] ?>" <?php if($o_tva['valeur']==$o_descriptionArticle['tva']){echo 'selected="true"';} ?>> <?php echo $o_tva['valeur'] ?>&nbsp;%</option>
<?php
    }
?>
                </select></td>
                <!-- Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client -->
                <td align="center" title="Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client"><input class="input_quantite" type="text" name="prix_ttc_echoppe[]" value="<?php echo $o_descriptionArticle['prix_ttc'] ?>"/>&nbsp;&euro;</td>
                <!-- Prix TTC rapporté à l'unité echoppe -->
                <td align="center" title="Prix TTC rapporté à l'unité echoppe"><?php echo $o_descriptionArticle['prix_echoppe_ttc_unite'] ?>&nbsp;&euro;/<?php echo $o_descriptionArticle['unite'] ?></td>
          </tr>
<?php
}
?>
        </tbody>
</table>
<form>
