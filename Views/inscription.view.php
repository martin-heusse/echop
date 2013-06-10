<h1>Inscription</h1>

<form name="formulaire" class="form_connexion"
action="<?php echo root ?>/inscription.php"
enctype="multipart/form-data"
method="post">

    <p><span class="form_col"><label>Login</label></span><input type="text"
name="login" required/></p>
    <p><span class="form_col"><label>Mot de passe</label></span><input type="password" name="motDePasse" required/></p>
    <p><span class="form_col"><label>Email</label></span><input type="text" name="email" required/></p>
    <input type="sumbit" value="S'enregistrer"/>
</form>

