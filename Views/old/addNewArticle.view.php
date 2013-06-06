<p><a class="action-navigation" href="<?php echo root;?>/article.php/afficher?idcat=<?php echo $o_categorie['id'] ?>">Retour</a></p>

<h1><?php echo $o_categorie['nom'] ?></h1>

<h2>Ajout d'un article</h2>

<form name="formulaire"
action="<?php echo root;?>/article.php/ajouter?idcat=<?php echo $o_categorie['id']; ?>"
enctype="multipart/form-data"
method="post">
<div class="article_bloc_gauche">
    <div class="article_groupe">
        <p><span class="form_col"><label>Catégorie</label></span><?php echo $o_categorie['nom']; ?></p>
        <p><span class="form_col"><label>Référence</label></span><input type="text" name="reference" /></p>
        <p><span class="form_col"><label>Nom</label></span><input type="text" name="nom" /></p>
    </div><!--  class="article_groupe" -->
    <div class="article_groupe">
        <input type="hidden" name="MAX_FILE_SIZE" value="3145728" /><!-- 3 Mo -->
        <p><span class="form_col"><label>Image</label></span><input type="file" name="image" /></p>
    </div><!--  class="article_groupe" -->
    <div class="article_groupe">
        <p><span class="form_col"><label>Hauteur (cm)</label></span><input type="text" name="hauteur" /></p>
        <p><span class="form_col"><label>Largeur (cm)</label></span><input type="text" name="largeur" /></p>
        <p><span class="form_col"><label>Poids (g)</label></span><input type="text" name="poids" /></p>
    </div><!--  class="article_groupe" -->
    <div class="article_groupe">
        <p><span class="form_col"><label>Prix gros (&euro;)</label></span><input type="text" name="prixGros" /></p>
        <p><span class="form_col"><label>Prix detail (&euro;)</label></span><input type="text" name="prixDetail" /></p>
    </div><!--  class="article_groupe" -->
    <div class="article_groupe">
        <p><span class="form_col"><label>Quantité reelle</label></span><input type="text" name="qteR" /></p>
        <p><span class="form_col"><label>Quantité virtuelle</label></span><input type="text" name="qteV" /></p>
    </div><!--  class="article_groupe" -->
</div><!-- class="article_bloc_gauche" -->
<input type="hidden" name="idcat" value="<?php echo $o_categorie['id'] ?>" />
<input type="submit" name="ajouter" value="Ajouter" />
</form>
