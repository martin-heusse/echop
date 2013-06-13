<h1>Mon profil</h1>

<form name="formulaire"
action="<?php echo root ?>/utilisateur.php/profil"
enctype="multipart/form-data"
method="post"

<p> Login : <?php echo $s_login ?> </p>
<p> Mot de passe :<input type="text" name="resetMdp" value="<?php echo $s_password ?>">  </p>
 
<p> Email :<input type="text" name="resetEmail" value="<?php echo $s_email?>"></p>
<input type="submit" value="Editer">
</form>

<?php
    if ($i_editProfile != 0) {
?>
<p> Votre profil a été mis à jour. </p>

<?php
    }
?>
