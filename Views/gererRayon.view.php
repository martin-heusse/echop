<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Gérer les rayons</h1>

<?php
// Trace
// print_r($to_descriptionArticle);
// print_r($to_fournisseur);
?>

<p> La liste des actions : </p>
<a href="http://localhost/echoppe/rayon.php/creerRayon"> créer un rayon <a/>
&nbsp
<a href="http://localhost/echoppe/rayon.php/creerRayon"> créer un article <a/>

<p> La liste des rayons : </p>
<?php
foreach ($to_rayon as $o_rayon) {
?>
<!-- affichage de la liste des rayons -->
<a href="http://localhost/echoppe/rayon.php/gererRayon?i_idRayon=<?php echo $o_rayon['id'] ?>">
<?php echo $o_rayon['nom'] ?>
</a>
&nbsp
<?php
}
?>

<!-- par défaut pas de rayon -->
<!-- reste à vérifier que l'utilisateur ne peut pas rentrer n'importe quoi dans l'URL -->
<?php
if ( isset($i_idRayon) ) {
?>
<!-- // Trace
<p> Il y a un rayon !</p> -->
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
            <!-- Seuil min -->
            <td> <?php echo $o_descriptionArticle['seuil_min'] ?> </td>

            <!-- Boucle pour afficher les fournisseurs disponibles -->
            <!-- A FAIRE -->
<?php
            foreach($to_fournisseur as $o_fournisseur){
                $nom = $o_fournisseur['nom'];
                if(isset($o_descriptionArticle[$nom])){
?>
            <td>code : <?php echo $o_descriptionArticle[$nom]['code'] ?>
                 <br />prix à verser au fournisseur : 
<?php
                    if($o_descriptionArticle[$nom]['prix_ht'] == ""){
                        echo $o_descriptionArticle[$nom]['prix_ttc'];
                    } else {
                        echo $o_descriptionArticle[$nom]['prix_ht'];
                    }
?>
              <br />prix ttc : <?php echo $o_descriptionArticle[$nom]['prix_ttc'] ?></td>
<?php
                } else {
?>
                <td> </td>
<?php
                }
            }
?>

            <!-- Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client -->
            <td> <?php echo $o_descriptionArticle['prix_ttc'] ?> </td>
            <!-- Prix TTC rapporté à l'unité echoppe -->
            <td> <?php echo $o_descriptionArticle['prix_echoppe_ttc'] ?> </td>
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
