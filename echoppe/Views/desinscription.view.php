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
    
    <center><img src="<?php echo root ?>/Layouts/images/warning.png" height="150" alt="<?php echo $titre_page ?>" />
    
<?php
if (Utilisateur::isLogged() && Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
    ?>
    <p><h3>Etes-vous bien sûr de vouloir désinscrire cet utilisateur ?</h3></p>
    <p><h4 class="erreur"> N'oubliez pas d'enregistrer les commandes de cet utilisateur pour ne pas perdre définitivement son historique !</h3></p>
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
    <input type="hidden" name='id_utilisateur_a_suppr' value="<?php echo $i_id ?>" >
    <input type="hidden" name='page' value="<?php echo $i_pagePrec?>" >
    <p><input type="submit" value="Valider"/></p>
</form>

</center>

    <?php

