<p><a class="action-navigation" href="<?php echo root;?>/article.php/afficher?idcat=<?php echo $o_article['idCategorie'] ?>">Retour</a></p>

<h1><?php echo $s_categorie ?></h1>

<h2>Suppression d'un article</h2>

<p>Etes vous sûr de vouloir supprimer l'article suivant ?</p>

<div id="article_bloc_gauche">
    <div class="article_groupe">
        <p><span class="form_col">Référence</span><?php echo $o_article['reference'] ?><br/>
        <p><span class="form_col">Nom</span><?php echo $o_article['nom'] ?></p>
    </div><!-- class="article_groupe" -->
</div><!-- id="article_bloc_gauche" -->

<div id="article_bloc_droit">
    <div class="article_groupe">
<?php if ($o_article['ts_photos'] != NULL) { ?>
        <p><span class="form_col">
<?php
    foreach ($o_article['ts_photos'] as $s_photo) {
?>
        <a class="fancybox" rel="group" title="<?php echo $o_article['reference'] ?>" href="<?php echo root ?>/produits/agrandies/<?php echo $s_photo ?>">
        <img src="<?php echo root ?>/produits/vignettes/<?php echo $s_photo ?>" alt=""/></a>
<?php
    }
?>
        </span></p>
<?php } ?>
    </div><!-- class="article_groupe" -->
</div><!-- id="article_bloc_droit" -->

<div class="clear"></div><!-- clear -->

<form name="formulaire"
action="<?php echo root ?>/article.php/supprimer?id=<?php echo $o_article['id'] ?>"
method="post">
    <input type="hidden" name="idcat" value="<?php echo $o_article['idCategorie'] ?>" />
    <input type="submit" name="supprimer" value="Oui" />
    <input type="submit" name="annuler" value="Non" />
</form>
