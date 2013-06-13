<h1>Mot de passe oublié</h1>

<p>Pour récupérer votre mot de passe, saisissez votre login.<br/>
Votre mot de passe vous sera renvoyé dans l'adresse email renseigné lors de votre inscription.</p>

<form name="formulaire" class="form_connexion"
action="<?php echo root ?>/connexion.php/connexion"
enctype="multipart/form-data"
method="post">
    <p><span class="form_col"><label>Login</label></span><input type="text" name="login"/></p>
    <input type="submit" value="Récupérer mon mot de passe"/>
</form>
