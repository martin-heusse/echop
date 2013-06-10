<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Liste de tous les utilisateurs</h1>

 <p>

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
<p> Il n'y a aucun utilisateur inscrit</p>
<?php
}
?>

