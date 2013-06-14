<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Gérer les rayons</h1>

<p> La liste des rayons : </p>
<ul>
<?php
foreach ($to_rayon as $o_rayon) {
    //affichage de la liste des rayons 
?>
<li><?php echo $o_rayon['nom'] ?></li>
<?php
}
?>
</ul>

<button><a href="<?php echo root ?>/rayon.php/creerRayon"> créer un rayon <a/></button>
<button><a href="<?php echo root ?>/rayon.php/modifierRayon"> modifier un rayon <a/></button>

