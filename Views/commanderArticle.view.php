<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<?php
if ($to_rayon != null) {
    if ($to_article != null) {
    /* Affichage des articles */
?>
        <table>
        <tr>
            <th>Produit</th>
            <th>Poids du paquet du fournisseur</th>
            <th>Unite</th>
            <th>Nombre de paquets par colis</th>
            <th>Prix TTC</th>
            <th>Prix TTC unitaire (au kilo/litre)</th>
            <th>Poids unitaire pour la commande</th>
            <th>Quantité minimale pour commande</th>
            <th>Quantite</th>
            <th>Quantité totale commandée</th>
            <th>Total TTC</th>
        </tr>


<?php 
    } else { 
/* Affichage des rayons */ 
?>
        <p> Choisissez un rayon :</p>
        <ul>
<?php
        foreach($to_rayon as $o_rayon) {
?>
            <li><a href="<?php echo root ?>/commande.php/commanderArticle?idRayon=<?php echo $o_rayon['id'] ?>"><?php echo $o_rayon['nom'] ?></a>
            </li>
<?php 
    }
?>
            </ul>
<?php
    }
} else {
?>

<p> Il n'y a actuellement aucun rayon disponible</p>

<?php
    }
?>
