<!-- affiche la liste de tous les fournisseurs -->
<div id="retour">
<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>
</div>

<h1>Liste de tous les fournisseurs</h1>

<ul>
<?php
foreach ($to_fournisseur as $o_fournisseur) {
?>  
    <li><?php echo $o_fournisseur['nom'] ?></li>
<?php
}
?>
</ul>
