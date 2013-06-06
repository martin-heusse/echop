<p><a class="action-navigation" href="<?php echo root ?>/article.php/afficher?idcat=<?php echo $o_article['idCategorie'] ?>">Retour</a></p>

<h1>Modification d'un article</h1>

<form name="formulaire"
action="<?php echo root ?>/article.php/modifier?id=<?php echo $o_article['id'] ?>"
enctype="multipart/form-data"
method="post">

    <div id="article_bloc_gauche">
        <div class="article_groupe">
            <span class="form_col"><label for="idCategorie">Catégorie</label></span>
            <select name="idCategorie">
<?php
foreach ($to_categories as $row) {
?>
        <option <?php if ($o_article['idCategorie'] == $row['id']) { ?>selected=selected <?php } ?>
            value="<?php echo $row['id'] ?>"><?php echo $row['nom'] ?></option>
<?php
}
?>
            </select>

            <span class="form_col"><label for="reference">Référence</label></span>
            <input type="text" id="reference" name="reference" value="<?php echo $o_article['reference'] ?>"/>

            <span class="form_col"><label for="nom">Nom</label></span>
            <input type="text" id="nom" name="nom" value="<?php echo $o_article['nom'] ?>"/>
        </div><!-- class="article_groupe" -->
        <div class="article_groupe">
            <span class="form_col"><label for="hauteur">Hauteur (cm)</label></span>
            <input type="text" id="hauteur" name="hauteur" value="<?php echo $o_article['hauteur'] ?>"/>
            <span class="form_col"><label for="largeur">Largeur (cm)</label></span>
            <input type="text" id="largeur" name="largeur" value="<?php echo $o_article['largeur'] ?>"/>
            <span class="form_col"><label for="poids">Poids (g)</label></span>
            <input type="text" id="poids" name="poids" value="<?php echo $o_article['poids'] ?>"/>
        </div><!-- class="article_groupe" -->
        <div class="article_groupe">
            <span class="form_col"><label for="prixGros">Prix gros (&euro;)</label></span>
            <input type="text" id="prixGros" name="prixGros" value="<?php echo $o_article['prixGros'] ?>"/>
            <span class="form_col"><label for="prixDetail">Prix détail (&euro;)</label></span>
            <input type="text" id="prixGros" name="prixDetail" value="<?php echo $o_article['prixDetail'] ?>"/>
        </div><!-- class="article_groupe" -->
        <div class="article_groupe">
            <span class="form_col"><label for="qteR">Quantité réelle</label></span>
            <input type="text" id="qteR" name="qteR" value="<?php echo $o_article['qteR'] ?>"/>
            <span class="form_col"><label for="qteV">Quantité virtuelle</label></span>
            <input type="text" id="qteV" name="qteV" value="<?php echo $o_article['qteV'] ?>"/>
        </div><!-- class="article_groupe" -->
    </div><!-- id="article_bloc_gauche"-->

    <div id="article_bloc_droit">
        <div class="article_groupe">
            <span class="form_col"><label for="image">Image</label></span>
            <input type="file" id="image" name="image" value=""/>
<?php
if ($o_article['ts_photos'] != NULL) {
?>
<?php
    foreach($o_article['ts_photos'] as $s_photo) {
?>
        <a class="fancybox" rel="group" title="<?php echo $o_article['reference'] ?>" href="<?php echo root ?>/produits/agrandies/<?php echo $s_photo ?>">
            <img src="<?php echo root ?>/produits/vignettes/<?php echo $s_photo ?>" alt=""/>
        </a>
<?php
    }
?>
<?php
}
?>
        </div><!-- class="article_groupe" -->
    </div><!-- id="article_bloc_droit"-->

    <div class="clear"></div><!-- clear -->

    <input type="hidden" name="idcat" value="<?php echo $o_article['idCategorie'] ?>"/>
    <input type="submit" name="modifier" value="Modifier"/>
</form>
