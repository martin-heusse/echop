<p><a class="action_navigation" href="<?php echo root ?>/rayon.php/afficherRayon">Retour</a></p>

<h1>Gérer tous les articles</h1>

<?php
// Trace
// print_r($to_descriptionArticle);
// print_r($to_fournisseur);
?>

<p> La liste des actions : </p>
<a href="<?php echo root ?>/article.php/creerArticle"> créer un article <a/>

<!-- par défaut pas de rayon -->
<table>
    <thead> <!-- En-tête du tableau -->
        <tr>
            <th>Produit</th>
            <th>Poids du paquet fournisseur</th>
            <th>Poids du paquet echoppe</th>
            <th>Unité</th>
            <th>Nombre de paquets par colis fournisseur</th>
            <th>Seuil min</th>

            <!-- Boucle pour afficher les fournisseurs disponibles -->
            <!-- A FAIRE -->
<?php
foreach($to_fournisseur as $o_fournisseur){
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
            <th>Description courte</th>
            <th>Description longue</th>
            <th>modification d'un article</th>
        </tr>
    </thead>

    <tbody> <!-- Corps du tableau -->
<?php
// Boucle sur tous les produits
foreach ($to_descriptionArticle as $o_descriptionArticle) {
?>
        <tr>
            <!-- création d'un formulaire -->
            <form method="post" action="<?php echo root ?>/article.php/modifierArticle">
                <input type="hidden" name="id_article" value="<?php echo $o_descriptionArticle['id_article'] ?>"/>
                <!-- Nom du produit -->
                <td title="Produit"><input type="text" name="nom_article" value="<?php echo $o_descriptionArticle['nom'] ?>"/></td>
                <!-- Poids du paquet fournisseur -->
                <td><input type="text" name="poids_paquet_fournisseur" value="<?php echo $o_descriptionArticle['poids_paquet_fournisseur'] ?>"/></td>
                <!-- Poids du paquet échoppe -->
                <td><input type="text" name="poids_paquet_client" value="<?php echo $o_descriptionArticle['poids_paquet_client'] ?>"/></td>
                <!-- Unité -->
                <td><input type="text" name="unite" value="<?php echo $o_descriptionArticle['unite'] ?>"/></td>
                <!-- Nombre de paquets par colis fournisseur -->
                <td><input type="text" name="nb_paquet_colis" value="<?php echo $o_descriptionArticle['nb_paquet_colis'] ?>"/></td>
                <!-- Seuil min -->
                <td><input type="text" name="seuil_min" value="<?php echo $o_descriptionArticle['seuil_min'] ?>"/></td>

                <!-- Boucle pour afficher les fournisseurs disponibles -->
                <!-- A FAIRE -->
<?php
    foreach($to_fournisseur as $o_fournisseur){
        $nom = $o_fournisseur['nom'];
        $id = $o_fournisseur['id'];
        if(isset($o_descriptionArticle[$nom])){
            if($o_descriptionArticle[$nom]['prix_ht'] == ""){
                $prix_fournisseur = $o_descriptionArticle[$nom]['prix_ttc'];
             } else {
                $prix_fournisseur = $o_descriptionArticle[$nom]['prix_ht'];
            }
?>
?>
            <td>code : <input type="text" name="code[<?php echo $id ?>]" value="<?php echo $o_descriptionArticle[$nom]['code']?>"/> <br />
                prix à verser au fournisseur : <input type="text" name="prix_fournisseur[<?php echo $id ?>]" value="<?php echo $prix_fournisseur ?>"/> <br />
                prix ttc : <input type="text" name="prix_ttc[<?php echo $id ?>]" value="<?php echo $o_descriptionArticle[$nom]['prix_ttc'] ?>"/></td>

<?php
        } else {
?>
                    <td> </td>
<?php
        }
    }
?>

                <!-- Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client -->
                <td><input type="text" name="prix_ttc_echoppe" value="<?php echo $o_descriptionArticle['prix_ttc'] ?>"/></td>
                <!-- Prix TTC rapporté à l'unité echoppe -->
                <!-- A FAIRE -->
                <td><?php echo $o_descriptionArticle['prix_echoppe_ttc_unite'] ?></td>
                <!-- TVA -->
                <td><input type="text" name="tva" value="<?php echo $o_descriptionArticle['tva'] ?>"/></td>
                <!-- Description courte -->
                <td><input type="text" name="description_courte" value="<?php echo $o_descriptionArticle['description_courte'] ?>"/></td>
                <!-- Description longue -->
                <td><input type="text" name="description_longue" value="<?php echo $o_descriptionArticle['description_longue'] ?>"/></td>
                <td><input type="submit" value="modifier article" /></td>
            <form>
       </tr>
<?php
}
?>
   </tbody>
</table>
