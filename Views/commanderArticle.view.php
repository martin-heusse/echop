<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<?php
    if ($to_rayon != null) {
        if ($to_article != null) {
        /* Affichage des articles */
?>
            
            <p>  <?php echo $o_rayon['nom']?>:  </p>
            <ul>

<?php
                foreach($to_article as $o_article) {
?>
                <li><?php echo $o_article['nom']?></li>
            </ul>
<?php 
                }
        } else { 
        /* Affichage des rayons */ 
?>
             <p> Choisissez un rayon :</p>
             <ul>
<?php
                 foreach($to_rayon as $o_rayon) {
?>
                <li><a href="<?php echo root ?>/commanderArticle?idRayon=<?php echo $o_rayon['id'] ?>"><?php echo $o_rayon['nom'] ?></a>
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
