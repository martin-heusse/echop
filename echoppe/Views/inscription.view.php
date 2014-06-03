<!-- interface d'inscription -->
<?php
if (Utilisateur::isLogged() && Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
    ?>
    <h1> Ajout d'un nouvel utilisateur </h1>
    <?php
} else {
    ?>
    <h1>Inscription</h1>

    <?php
}
if ($i_errReg != 0) {
    ?>
    <form name="formulaire" class="form_connexion"
    <?php
    if (Utilisateur::isLogged() && Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
        ?>
              action="<?php echo root ?>/utilisateur.php/ajouterUtilisateur"
              <?php
          } else {
              ?>
              action="<?php echo root ?>/inscription.php/inscription"
              <?php
          }
          ?>
          enctype="multipart/form-data"
          method="post">

        <p><span class="form_col"><label>Login</label></span><input type="text"
                                                                    name="login" required/></p>
            <?php
            if ($i_errLogin == 1) {
                ?>
            <p class="erreur">Erreur: Login déjà existant</p>
            <?php
        }
        ?>
        <p><span class="form_col"><label>Nom</label></span><input type="text" name="nom" required/></p>
        <p><span class="form_col"><label>Prénom</label></span><input type="text" name="prenom" required/></p>   
        <p><span class="form_col"><label>Mot de passe</label></span><input type="text" name="motDePasse" required/></p>
        <p><span class="form_col"><label>Email</label></span><input type="text" name="email" required/></p>
        <?php
        if (Utilisateur::isLogged() && Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
            ?>
            <input type="submit" value="Valider"/>
            <?php
        } else {
            ?>
            <input type="submit" value="S'enregistrer"/>
        </form>

        <?php
    }
} else {
    ?>
    <?php
    if (Utilisateur::isLogged() && Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
        ?>
        <p class="succes"> L'utilisateur a été ajouté avec succès.</p>
        
        <a href="<?php echo root ?>/utilisateur.php/listeUtilisateurValide">Retour à la liste des utilisateurs</a>
       
        <?php
    } else {
        ?>

        <p class="succes"> Votre inscription a été soumise à la validation par un administrateur.</p><p> Vous recevrez un mail de confirmation d'un administrateur lorsque votre inscription aura été validée et ce n'est qu'à partir de ce moment là que vous pourrez accéder au site.</p>
        <?php
    }
}
?>
