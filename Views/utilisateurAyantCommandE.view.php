<h1>Commande de l'utilisateur AJOUTER LOGIN </h1>

 <p>

<?php
if ($to_commande != null) {
   ?> 
<ul>
<?php
   foreach($to_commande as $o_utilisateur) {
    ?>
<li>
  <?php
  echo $o_utilisateur['login_utilisateur']?>
  </li>
<?php
     }
?>
</ul>
<?php
} else {
?>
<p> Aucun utilisateur n'a fait de commande</p>
<?php
}
?>

