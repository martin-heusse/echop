<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Liste des utilisateurs ayant commandé</h1>

<p>Liste des utilisateurs ayant passé une commande pour la campagne courante.<br/>
Cliquez sur un nom d'utilisateur pour voir la liste des produits qu'il a commandé.</p>

<?php
if ($to_commande != null) {
?> 
<ul>
<?php
    foreach($to_commande as $o_utilisateur) {
?>
    <li><a href="../commande.php/commandeUtilisateur?idUtilisateur=<?php echo $o_utilisateur['id_utilisateur']?>">
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

