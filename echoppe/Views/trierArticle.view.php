<!DOCTYPE html>
<html>
<body>
    
<h1>Trier les articles </h1>

<div id="retour">
<!-- interface de parcours d'historique des campagnes pour utilisateur -->
<p><a class="action_navigation" href="<?php echo root ?>/article.php/afficherArticle">Retour à la gestion d'article</a></p>
    </div>
<?php
if($to_categorie == array()){ 
?>
    <p><?php echo "Il n'y a rien à trier dans ce rayon !"; ?></p>
<?php 
    return;
}
?>
<div id="columns">
<?php

        foreach ($to_categorie as $o_categorie) {
        $i_nbreArticleCategorie = 0;
        foreach ($to_descriptionAllArticle as $o_descriptionAllArticle) {
            if ($o_descriptionAllArticle['id_categorie'] == $o_categorie['id']) {                
                $i_nbreArticleCategorie++;
                $cat_vide = true;
            }
        }
        if ($i_nbreArticleCategorie != 0){ ?>
            <li> <p> <a href="<?php echo root ?>/article.php/insideCategorieTri?id_categ=<?php echo $o_categorie['id'] ?>&id_ray=<?php echo $_GET['i_idRayon'] ?>">Trier les articles de la catégorie : <?php echo $o_categorie['nom']; ?></a></li>
            <?php
        }
        
        }?>


       
</div>

<script src="../js/script.js"></script>
</body>
</html>
