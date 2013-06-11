<h1>Connexion</h1>

<form name="formulaire" class="form_connexion"
action="<?php echo root ?>/connexion.php/connexion"
enctype="multipart/form-data"
method="post">
    <p><span class="form_col"><label>Login</label></span><input type="text" name="login"/></p>
    <p><span class="form_col"><label>Mot de passe</label></span><input type="password" name="motDePasse"/></p>
    <input type="submit" value="Se connecter"/>
    <p><a href="<?php echo root ?>/inscription.php/mdpOublie">Mot de passe oublié ?</a><br/>
    <a href="<?php echo root ?>/inscription.php/inscription">S'inscrire</a></p>
<p>Pas encore inscrit ? Inscrivez-vous maintenant !</p>
</form>
