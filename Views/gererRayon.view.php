<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

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

<a href="<?php echo root ?>/rayon.php/creerRayon"> créer un rayon <a/> &nbsp;
<a href="<?php echo root ?>/rayon.php/modifierRayon"> modifier un rayon <a/>

<h1>Gérer les catégories</h1>

<p>Liste des catégories :</p>
<ul>
<?php
foreach ($to_categorie as $o_categorie) {
    //affichage de la liste des rayons 
?>
<li><?php echo $o_categorie['nom'] ?></li>
<?php
}
?>
</ul>

<a href="<?php echo root ?>/categorie.php/creerCategorie">créer une catégorie<a/> &nbsp;
<a href="<?php echo root ?>/categorie.php/modifierCategorie">modifier une catégorie<a/>
