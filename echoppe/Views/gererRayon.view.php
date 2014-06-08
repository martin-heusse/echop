<!-- interface de gestion des rayons (ajouter, modifer) -->
<div id="retour">
<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Gérer les rayons</h1>
<center><a href="<?php echo root ?>/rayon.php/creerRayon"> Créer un rayon </a> &nbsp;
    <a href="<?php echo root ?>/rayon.php/modifierRayon"> Modifier un rayon </a></center>

<p><strong> La liste des rayons : </strong></p>
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

<h1>Gérer les catégories</h1>
<center><a href="<?php echo root ?>/categorie.php/creerCategorie">Créer une catégorie</a> &nbsp;
    <a href="<?php echo root ?>/categorie.php/modifierCategorie">Modifier une catégorie</a></center>

<p><strong>Liste des catégories :</strong></p>
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

</div>
