<p><a class="action_navigation" href="<?php echo root ?>/commande.php/articlesCommandEs">Retour</a></p>

<h1>Utilisateurs ayant commandé cet article</h1>

<ul>
<?php
foreach ($to_utilisateur as $o_utilisateur) {
?>
    <li><a href="<?php echo root ?>/commande.php/commandeUtilisateur?idUtilisateur=<?php echo $o_utilisateur['id']?>"><?php echo $o_utilisateur['login'] ?></a></li>
<?php
}
?>
</ul>
