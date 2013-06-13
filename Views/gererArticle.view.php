<p><a class="action_navigation" href="<?php echo root ?>/rayon.php/afficherRayon">Retour</a></p>

<h1>Gérer tous les articles</h1>

<p>La liste des actions :</p>
<a href="<?php echo root ?>/article.php/creerArticle">Créer un article</a>

<!-- Création d'un formulaire englobant tout le tableau -->
<form method="post" action="<?php echo root ?>/article.php/modifierArticle">
<table>
    <thead> <!-- En-tête du tableau -->
        <tr>
            <th>Produit</th>
            <th>Poids du paquet fournisseur</th>
            <th>Poids du paquet client</th>
            <th>Unité</th>
            <th>Nombre de paquets par colis fournisseur</th>
            <th>Seuil min</th>
<?php
foreach($to_fournisseur as $o_fournisseur){
//boucle pour afficher le nom de tous les fournisseurs
?>
            <th><?php echo $o_fournisseur['nom'] ?></th>
<?php
}
?>
            <!-- colonne informative attention aux arrondis -->
            <th>Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client</th>
            <!-- colonne informative -->
            <th>Prix TTC rapporté à l'unité echoppe</th>
            <th>TVA</th>
            <!--
            <th>Description courte</th>
            <th>Description longue</th>
            -->
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
                <input type="hidden" name="id_article_campagne[<?php echo $i_idArticleCampagne ?>]" value="<?php echo $i_idArticleCampagne ?>"/>
                <!-- Nom du produit -->
                <td title="Produit"><?php echo $o_descriptionArticle['nom'] ?></td>
                <!-- Poids du paquet fournisseur -->
                <td><?php echo $o_descriptionArticle['poids_paquet_fournisseur'] ?></td>
                <!-- Poids du paquet échoppe -->
                <td><input type="text" name="poids_paquet_client[<?php echo $i_idArticleCampagne ?>]" value="<?php echo $o_descriptionArticle['poids_paquet_client'] ?>"/></td>
                <!-- Unité -->
                <td><?php echo $o_descriptionArticle['unite'] ?></td>
                <!-- Nombre de paquets par colis fournisseur -->
                <td><?php echo $o_descriptionArticle['nb_paquet_colis'] ?></td>
                <!-- Seuil min -->
                <td><input type="text" name="seuil_min[<?php echo $i_idArticleCampagne ?>]" value="<?php echo $o_descriptionArticle['seuil_min'] ?>"/></td>

                <!-- Boucle pour afficher les fournisseurs disponibles -->
                <!-- A FINIR -->
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
                <td>code : <?php echo $o_descriptionArticle[$id]['code']?> <br />
                    prix à verser au fournisseur : <?php echo $prix_fournisseur ?> <br />
                    prix ttc : <?php echo $o_descriptionArticle[$id]['prix_ttc'] ?>
                    choisir le fournisseur : <input type="radio" name="fournisseur_choisi[<?php echo $i_idArticleCampagne ?>][]" value="<?php echo $id ?>"  <?php if($id==$o_descriptionArticle['id_fournisseur']){echo 'checked="true"';} ?>></td>
<?php
        } else {
?>
                <td> </td>
<?php
        }
    }
?>

                <!-- Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client -->
                <td><input type="text" name="prix_ttc_echoppe[<?php echo $i_idArticleCampagne ?>]" value="<?php echo $o_descriptionArticle['prix_ttc'] ?>"/></td>
                <!-- Prix TTC rapporté à l'unité echoppe -->
                <!-- A FAIRE -->
                <td><?php echo $o_descriptionArticle['prix_echoppe_ttc_unite'] ?></td>
                <!-- TVA -->
                <td><select name="tva[<?php echo $i_idArticleCampagne ?>]">
<?php
    foreach($to_tva as $o_tva){
?>
                    <option value="<?php echo $o_tva['valeur'] ?>" <?php if($o_tva['valeur']==$o_descriptionArticle['tva']){echo 'selected="true"';} ?>> <?php echo $o_tva['valeur'] ?></option>
<?php
    }
?>
                </select></td>
                <!-- Description courte -->
                <!--<td><?php echo $o_descriptionArticle['description_courte'] ?></td>-->
                <!-- Description longue -->
                <!--<td><?php echo $o_descriptionArticle['description_longue'] ?></td>-->
          </tr>
<?php
}
?>
        </tbody>
</table>
<input type="submit" class="input_valider" value="Mettre à jour les articles"/>
<form>
