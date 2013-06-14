<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<?php
/* Indique si la campagne est ouverte ou non */
if ($b_etat == 1) {
?>
        <div class="indication_campagne"><span class="campagne_ouverte">Campagne ouverte</span></div>
<?php
} else {
?>
        <div class="indication_campagne"><span class="campagne_fermee">Campagne fermée</span></div>
<?php
}
if ($to_rayon != 0 and $to_rayon != array()) {
?>
        <ul>
<?php 
    foreach($to_rayon as $o_rayon) { 
?>
                    <li> <a href="<?php echo root ?>/commanderArticle.php/commanderArticle?idRayon=<?php echo $o_rayon['id']?>"><?php echo $o_rayon['nom'] ?></a></li>
<?php
    }
} else {
?> 
Il n'y a aucun rayon
<?php
}
?>
