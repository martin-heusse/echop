<!-- affiche la liste des utilisateurs avec le login et l'adresse mail -->
<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Liste de tous les utilisateurs</h1>

 <a href="<?php echo root ?>/utilisateur.php/ajouterUtilisateur">Créer un nouvel utilisateur</a>

 <p>

<?php
if ($to_utilisateur != null) {
   ?> 
<table >
  <tr>
    <th> Login </th>
    <th> Adresse Mail </th>
    <tr/>
<?php
   foreach($to_utilisateur as $o_utilisateur) {
    ?>
  <tr>
    <td> <?php echo $o_utilisateur['login']?> </td>
    <td> <?php echo $o_utilisateur['email']?> </td>
  </tr>
<?php
     }
?>
</table> 

<?php
} else {
?>
<p class="message"> Il n'y a aucun utilisateur inscrit</p>
<?php
}
?>