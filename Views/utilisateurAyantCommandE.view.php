<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Liste des utilisateurs ayant passé une commande</h1>

<p>
<?php
if ($to_commande != null) {
?> 
<ul>
<?php
    foreach($to_commande as $o_utilisateur) {
?>
    <li><a href="../commande.php/commandeUtilisateur?id_utilisateur=<?php echo $o_utilisateur['id_utilisateur']?>">
    <?php echo $o_utilisateur['login_utilisateur'] ?></a></li>
<?php
    }
?>
</ul>
<?php
} else {
?>
<p> Aucun utilisateur n'a fait de commande.</p>
<?php
}
?>

