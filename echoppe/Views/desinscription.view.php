<!-- interface de désinscription -->
<?php
if (Utilisateur::isLogged() && Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
    ?>
    <h1> Suppression d'un utilisateur </h1>
    <?php
} else {
    ?>
    <h1>Désinscription</h1>

    <?php
}
?>
<?php
if (Utilisateur::isLogged() && Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
    ?>
    <p>Etes-vous bien sûr de vouloir désinscrire cet utilisateur ?</p>
    <?php
}
else {
?>
<p>Etes-vous bien sûr de vouloir vous désinscrire ?</p>
<?php 
}
?>
<form action="<?php echo root ?>/inscription.php/desinscription" enctype="multipart/form-data" method="post" name="formulaire">
    <input type="radio" name="confirm" value="1"/> Oui 
    <input type="radio" name="confirm" value="0" /> Non
    <input type="hidden" name='id_utilisateur_a_suppr' value='<?php echo $i_login ?>' >
    <p><input type="submit" value="Valider"/></p>
</form>

    <?php

