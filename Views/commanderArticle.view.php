<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<?php
    if ($to_rayon != null) {
?>
    <p> Choisissez un rayon :</p>
    <ul>
<?php
        foreach($to_rayon as $o_rayon) {
?>
        <li><a href="<?php echo root?>/commanderArticle&
        <?php $o_rayon['id']?>"><?php echo $o_rayon['nom']?></a>
        </li>
<?php } ?>
    </ul>
<?php
    } else {
?>
<p> Il n'y a actuellement aucun rayon disponible</p>

<?php
    }
?>
