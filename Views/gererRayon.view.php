<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Gérer les rayons</h1>

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
    if ( $to_article == array()) {
?>
<p> Il n'y a pas d'articles pour ce rayon </p>
<?php
    } else {
?>
<table>
    <thead> <!-- En-tête du tableau -->
        <tr>
            <th>Code de l'article du fournisseur choisi</th>
            <th>Produit</th>
            <th>Poids du paquet fournisseur</th>
            <th>Poids du paquet echoppe</th>
            <th>Unité</th>
            <th>Nombre de paquets par colis echoppe<th>
            <th>Nombre de paquets par colis fournisseur<th>
            <!-- Boucle pour afficher les tarifs de tous les fournisseurs en HT ou TTC si TVA -->
<?php
        foreach ($to_fournisseur as $o_fournisseur) {
?>
            <th><?php echo $o_fournisseur['nom'] ?></th>
<?php
        }
?>
            <!-- la colonne suivante est informative -->
            <th>Prix HT rapporté au paquet de l'échoppe auprès du founisseur</th>
            <th>Prix HT rapporté au paquet de l'échoppe vendu au client</th>
            <!-- colonne informative -->
            <th>Prix HT rapporté à l'unité echoppe</th>
        </tr>
    </thead>
    <tbody> <!-- Corps du tableau -->
    
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
