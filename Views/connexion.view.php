<h1>Connexion</h1>

<form name="formulaire" class="form_connexion"
action="<?php echo root ?>/connexion.php/connexion"
enctype="multipart/form-data"
method="post">
    <p><span class="form_col"><label>Login</label></span><input type="text" name="login"/></p>
    <p><span class="form_col"><label>Password</label></span><input type="password" name="password"/></p>
    <input type="submit" value="Se connecter"/>
</form>
