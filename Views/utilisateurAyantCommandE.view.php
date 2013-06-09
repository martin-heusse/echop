<h1>Liste des Utilisateurs ayant passés une commande </h1>

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

<a href="../commande.php/commandeUtilisateur?id_utilisateur=$o_utilisateur['id_utilisateur']">
  echo $o_utilisateur['login_utilisateur']?>

</a>
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

