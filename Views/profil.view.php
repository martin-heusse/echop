<!-- interface de gestion du profil (modification mot de passe et adresse mail-->
<p>
    <a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a>
</p>
<h1>Mon profil</h1>

<form name="formulaire"
action="<?php echo root ?>/utilisateur.php/profil"
enctype="multipart/form-data"
method="post"

<p><span class="form_col">Login</span><?php echo $s_login ?> </p>
<p><span class="form_col">Mot de passe</span><input type="text" name="resetMdp" value="<?php echo $s_password ?>">  </p>

<p><span class="form_col">Email</span><input type="text" name="resetEmail" value="<?php echo $s_email?>"></p>
<input type="submit" value="Editer">
</form>

<?php
if ($i_editProfile != 0) {
?>
<p class="succes">Votre profil a été mis à jour.</p>

<?php
}
?>
