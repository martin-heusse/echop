<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Liste des inscriptions d'utilisateurs à valider</h1>

 <p>
<?php
if ($i_nombreUtilisateurAValider == 1){
?>
Il y a <?php echo $i_nombreUtilisateurAValider?> utilisateur à valider. 
<?php } else { ?>
Il y a <?php echo $i_nombreUtilisateurAValider?> utilisateurs à valider.
<?php } ?>
<?php
if ($to_utilisateur != null) {
   ?> 
<ul>
<?php
   foreach($to_utilisateur as $o_utilisateur) {
    ?>
<li>
  <?php
  echo $o_utilisateur['login']?>
  </li>
<?php
     }
?>
</ul>

<?php
} else {
?>
<p> Il n'y a aucun utilisateur à valider</p>
<?php
}
?>
