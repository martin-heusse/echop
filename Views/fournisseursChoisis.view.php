<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Fournisseurs choisis</h1>

<ul>
<?php
foreach ($to_fournisseur as $o_fournisseur) {
?>
<li><a href="<?php echo root ?>/articleCampagne.php/commandeFournisseur?idFournisseur=<?php echo $o_fournisseur['id'] ?>"><?php echo $o_fournisseur['nom'] ?></a></li>
<?php
}
?>
</ul>
