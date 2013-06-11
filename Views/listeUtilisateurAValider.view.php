<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Liste des inscriptions d'utilisateurs à valider</h1>

 <p>
<?php
if ($i_nombreUtilisateurAValider == 1){
?>
Il y a <?php echo $i_nombreUtilisateurAValider?> utilisateur à valider : 
<?php
} else {
?>
Il y a <?php echo $i_nombreUtilisateurAValider?> utilisateurs à valider :
<?php
}
?>
<?php
if ($to_utilisateur != null) {
?> 
<table>
  <tr>
    <th> Login </th>
    <th> Adresse mail </th>
    <th> Valider l'inscription </th>
    <th> Refuser l'inscription </th>
  </tr>

<?php
    foreach($to_utilisateur as $o_utilisateur) {
?>
  <tr>
    <td> <?php echo $o_utilisateur['login']?> </td>
    <td><?php echo $o_utilisateur['email']?> </td>
    <td><a href="<?php echo root ?>/utilisateur.php/validerInscription?idUtilisateur=<?php echo $o_utilisateur['id']?>"> Valider </a> </td>
    <td> <a href="<?php echo root ?>/utilisateur.php/refuserInscription?idUtilisateur=<?php echo $o_utilisateur['id']?>"> <?php echo $o_utilisateur['id']?> Refuser </a> </td>
  </tr>

<?php
    }
?>
</table>

<?php
} else {
?>
<p> Il n'y a aucun utilisateur à valider</p>
<?php
}
?>
