<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Fournisseurs choisis</h1>

<p>Liste de tous les founisseurs choisis pour la campagne courante.<br/>
Cliquez sur un nom de fournisseur pour voir les commandes associées pour la campagne courante.</p>

<ul>
<?php
foreach ($to_fournisseur as $o_fournisseur) {
?>
<li><a href="<?php echo root ?>/articleCampagne.php/commandeFournisseur?idFournisseur=<?php echo $o_fournisseur['id'] ?>"><?php echo $o_fournisseur['nom'] ?></a></li>
<?php
}
?>
</ul>
