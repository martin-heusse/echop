<p>
    <a class="action_navigation" href="<?php echo root ?>">Retour</a>
<?php
if(isset($i_erreur)){
    if($i_erreur==0){
        echo "Vos articles ont été modifiés !";
    }
    if($i_erreur==1){
        echo "Erreur de saisie, les articles n'ont pas été modifiés !";
    }
}
?>
</p>

<h1>Gérer tous les articles</h1>

<?php
// Trace
// print_r($to_descriptionArticle);
// print_r($to_fournisseur);
?>

<!-- Création d'un formulaire englobant tout le tableau -->
<form method="post" action="<?php echo root ?>/article.php/modifierArticle">

<p>La liste des actions :
<a href="<?php echo root ?>/article.php/afficherCreerArticle">Créer un article</a>
<input align="middle" type="submit" class="input_valider" value="Mettre à jour les articles"/>
</p>

<table style="font-size:10px;">
    <thead> <!-- En-tête du tableau -->
        <tr>
            <th>Produit</th>
            <th>Description courte</th>
            <th>Description longue</th>
            <th>Nombre de paquets par colis</th>
            <th>Poids du paquet fournisseur</th>
            <th>Poids du paquet client</th>
            <th>Seuil min</th>
<?php
foreach($to_fournisseur as $o_fournisseur){
//boucle pour afficher le nom de tous les fournisseurs
?>
            <th><?php echo $o_fournisseur['nom'] ?></th>
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
// $i_numLigne représente pair ou impair pour l'affichage une ligne sur deux
$i_numLigne = 0;
foreach ($to_descriptionArticle as $o_descriptionArticle) {
// boucle pour affcher tous les produits
$i_idArticleCampagne = $o_descriptionArticle['id'];
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
                <!-- Nombre de paquets par colis fournisseur -->
                <td align="center" title="Nombre de paquets par colis"><?php echo $o_descriptionArticle['nb_paquet_colis'] ?></td>
                <!-- Poids du paquet fournisseur -->
                <td align="center" title="Poids du paquet fournisseur" ><?php echo $o_descriptionArticle['poids_paquet_fournisseur'] ?>&nbsp;<?php echo $o_descriptionArticle['unite'] ?></td>
                <!-- Poids du paquet client -->
                <td align="center" title="Poids du paquet client"><div><input class="input_quantite" type="text" name="poids_paquet_client[]" value="<?php echo $o_descriptionArticle['poids_paquet_client'] ?>"/>&nbsp;<?php echo $o_descriptionArticle['unite'] ?></div></td>
                <!-- Seuil min -->
                <td align="center" title="Seuil min que peut choisir le client"><input class="input_quantite" type="text" name="seuil_min[]" value="<?php echo $o_descriptionArticle['seuil_min'] ?>"/></td>

                <!-- Boucle pour afficher les fournisseurs disponibles -->
<?php
   $i_idFournisseurChoisi = $o_descriptionArticle['id_fournisseur'];
    foreach($to_fournisseur as $o_fournisseur){
        $i_idFournisseur = $o_fournisseur['id'];
        if(isset($o_descriptionArticle[$i_idFournisseur])){
            if($o_descriptionArticle[$i_idFournisseur]['prix_ht'] == ""){
                $prix_fournisseur = $o_descriptionArticle[$i_idFournisseur]['prix_ttc'];
             } else {
                $prix_fournisseur = $o_descriptionArticle[$i_idFournisseur]['prix_ht'];
            }
?>
                <td title="Fournisseur : <?php echo $o_fournisseur['nom']; ?>">
                    <table style="width:100%; font-size:9px;">
                        <th>code</th>
                        <th>prix</th>
                        <th>prix ttc</th>
                        <th>Choisir</th>
                        <tr>
                            <td><?php echo $o_descriptionArticle[$i_idFournisseur]['code'] ?></td>
                            <td><?php echo $prix_fournisseur ?>&nbsp;&euro;</td>
                            <td><?php echo $o_descriptionArticle[$i_idFournisseur]['prix_ttc'] ?>&nbsp;&euro;</td>
                            <td><input type="radio" name="id_fournisseur_choisi[<?php echo $i_idArticleCampagne ?>]" value="<?php echo $i_idFournisseur ?>"  <?php if($i_idFournisseur==$i_idFournisseurChoisi){echo 'checked="true"';} ?>></td>
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
                <td align="center" title="TVA" ><select name="id_tva[]">
<?php
    foreach($to_tva as $o_tva){
        $i_idTva = $o_tva['id'];
        $f_valeurTva = $o_tva['valeur'];
        $i_idTvaChoisi = $o_descriptionArticle['id_tva_choisi'];
?>
                    <option value="<?php echo $i_idTva ?>" <?php if($i_idTva==$i_idTvaChoisi){echo 'selected="true"';} ?>> <?php echo $f_valeurTva ?>&nbsp;%</option>
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
