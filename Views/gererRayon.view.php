<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Gérer les rayons</h1>

<?php
// Trace
print_r($to_descriptionArticle);
//print_r($to_fournisseur);
?>

<?php
foreach ($to_rayon as $o_rayon) {
?>

<!-- affichage de la liste des rayons -->
<a href="http://localhost/echoppe/rayon.php/gererRayon?i_idRayon=<?php echo $o_rayon['id'] ?>">
<?php echo $o_rayon['nom'] ?>
</a>
<?php
}
?>
<!-- par défaut pas de rayon -->
<!-- reste à vérifier que l'utilisateur ne peut pas rentrer n'importe quoi dans l'URL -->
<?php
if ( isset($i_idRayon) ) {
?>
<p> Il y a un rayon !</p>
<?php 
    if ( $to_descriptionArticle == array()) {
?>
<p> Il n'y a pas d'articles pour ce rayon </p>
<?php
    } else {
?>
<table>
    <thead> <!-- En-tête du tableau -->
        <tr>
            <th>Produit</th>
            <th>Poids du paquet fournisseur</th>
            <th>Poids du paquet echoppe</th>
            <th>Unité</th>
            <th>Nombre de paquets par colis fournisseur</th>

            <!-- Boucle pour afficher les fournisseurs disponibles -->
            <!-- A FAIRE -->
<?php
        foreach($to_fournisseur as $o_fournisseur){
?>
        <th><?php echo $o_fournisseur['nom'] ?></th>
<?php
        }
?>

            <th>Prix HT ou TTC dépensé par l'échoppe pour un colis auprès du founisseur choisi</th>
            <th>Taxe à payer par l'échoppe pour un colis du fournisseur choisi</th>
            <!-- colonne informative attention aux arrondis -->
            <th>Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client</th>
            <!-- colonne informative -->
            <th>Prix TTC rapporté à l'unité echoppe</th>
            <th>TVA</th>
            <th>Description courte</th>
            <th>Description longue</th>
        </tr>
    </thead>
    <tbody> <!-- Corps du tableau -->
<?php
        // Boucle sur les produits du rayon
        foreach ($to_descriptionArticle as $o_descriptionArticle) {
?>
        <tr>
            <!-- Nom du produit -->
            <td> <?php echo $o_descriptionArticle['nom'] ?> </td>
            <!-- Poids du paquet fournisseur -->
            <td> <?php echo $o_descriptionArticle['poids_paquet_fournisseur'] ?> </td>
            <!-- Poids du paquet échoppe -->
            <td> <?php echo $o_descriptionArticle['poids_paquet_client'] ?> </td>
            <!-- Unité -->
            <td> <?php echo $o_descriptionArticle['unite'] ?> </td>
            <!-- Nombre de paquets par colis fournisseur -->
            <td> <?php echo $o_descriptionArticle['nb_paquet_colis'] ?> </td>

            <!-- Boucle pour afficher les fournisseurs disponibles -->
            <!-- A FAIRE -->
<?php
        foreach($to_fournisseur as $o_fournisseur){
            $nom = $o_fournisseur['nom'];
?>
            <td>code : <?php echo $o_descriptionArticle[$nom]['code'] ?> <br />
                prix : <?php echo $o_descriptionArticle[$nom]['prix_article'] ?>
            </td>
<?php
            }
?>
            <!-- Taxe à payer par l'échoppe pour un colis du fournisseur choisi -->
            <td> <?php echo $o_descriptionArticle ?> </td>
            <!-- Prix HT ou TTC dépensé par l'échoppe pour un colis auprès du founisseur choisi -->
            <!-- Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client -->
            <td> <?php echo $o_descriptionArticle ?> </td>
            <!-- Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client -->
            <td> <?php echo $o_descriptionArticle ?> </td>
            <!-- Prix TTC rapporté à l'unité echoppe -->
            <td> <?php echo $o_descriptionArticle ?> </td>
            <!-- TVA -->
            <td> <?php echo $o_descriptionArticle['tva'] ?> </td>
            <!-- Description courte -->
            <td> <?php echo $o_descriptionArticle['description_courte'] ?> </td>
            <!-- Description longue -->
            <td> <?php echo $o_descriptionArticle['description_longue'] ?> </td>
       </tr>
<?php
        }
?>
   </tbody>
</table>
<?php
    }
?>
<?php
} else { 
?>
<p> Choisissez votre rayon !</p>
<?php
}
?>
