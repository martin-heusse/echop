<?php
if (isset($o_categorie['nom'])) {
?>
<p><a class="action-navigation" href="<?php echo root ?>/article.php">Retour</a></p>

<h1><?php echo $o_categorie['nom'] ?></h1>

<p><a href="<?php echo root ?>/article.php/ajouter?idcat=<?php echo $o_categorie['id'] ?>">Ajouter un article</a></p>

<?php
}
?>

<?php
if ($to_articles != null) {
?>
<table>
    <tr>
        <th>&nbsp;</th>
        <th>Réf.</th>
        <th>Nom</th>
        <th>Haut.</th>
        <th>Larg.</th>
        <th>Poids</th>
        <th>Prix G</th>
        <th>Prix D</th>
        <th>Qté R</th>
        <th>Qté V</th>
        <th>&nbsp;</th>
    </tr>
<?php
    $numLigne = 0;
    foreach ($to_articles as $row) {
        $numLigne = ($numLigne + 1) % 2;
?>
    <tr class="ligne_article<?php echo $numLigne ?>">
<?php
        if ($row['ts_photos'] != NULL) {
?>
        <td class="center">
<?php
            foreach ($row['ts_photos'] as $s_photo) {
?>
            <a class="fancybox" rel="group" title="<?php echo $row['reference'] ?>" href="<?php echo root ?>/produits/agrandies/<?php echo $s_photo ?>">
                <img src="../Layouts/images/pic.png"/></a>
<?php
            }
?>
        </td>
<?php
        } else {
?>
        <td></td>
<?php
        }
?>
        <td onclick="location.href='article.php/modifier?id=<?php echo $row['id'] ?>'"><?php echo $row['reference'] ?></td>
        <td onclick="location.href='article.php/modifier?id=<?php echo $row['id'] ?>'"><?php echo $row['nom'] ?></td>
        <td class="nombre" onclick="location.href='article.php/modifier?id=<?php echo $row['id'] ?>'"><?php echo $row['hauteur'] ?></td>
        <td class="nombre" onclick="location.href='article.php/modifier?id=<?php echo $row['id'] ?>'"><?php echo $row['largeur'] ?></td>
        <td class="nombre" onclick="location.href='article.php/modifier?id=<?php echo $row['id'] ?>'"><?php echo $row['poids'] ?></td>
        <td class="nombre" onclick="location.href='article.php/modifier?id=<?php echo $row['id'] ?>'"><?php echo $row['prixGros'] ?>&euro;</td>
        <td class="nombre" onclick="location.href='article.php/modifier?id=<?php echo $row['id'] ?>'"><?php echo $row['prixDetail'] ?>&euro;</td>
        <td class="nombre" onclick="location.href='article.php/modifier?id=<?php echo $row['id'] ?>'"><?php echo $row['qteR'] ?></td>
        <td class="nombre" onclick="location.href='article.php/modifier?id=<?php echo $row['id'] ?>'"><?php echo $row['qteV'] ?></td>
        <td class="center"><a href="<?php echo root ?>/article.php/supprimer?id=<?php echo $row['id'] ?>"><img src="../Layouts/images/cross.png"></a></td>
    </tr>
<?php
    }
?>
</table>
<?php
} else {
?>
<p>Il n'y a aucun article dans cette catégorie.</p>
<?php
}
?>
