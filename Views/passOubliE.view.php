<h1>Mot de passe oublié</h1>

<?php
if ($b_success == 0) {
    if($b_erreurLogin == 1) {
?>
<p class="erreur">Le login saisi n'existe pas.</p>
<?php
    } else if ($b_erreurLogin == 0) {
?>
<p>Pour récupérer votre mot de passe, saisissez votre login.<br/>
Votre mot de passe vous sera renvoyé dans l'adresse email renseignée lors de votre inscription.</p>

<form name="formulaire" class="form_connexion"
action="<?php echo root ?>/inscription.php/passOubliE"
enctype="multipart/form-data"
method="post">
    <p><span class="form_col"><label>Login</label></span><input type="text" name="login"/></p>
    <input type="submit" value="Récupérer mon mot de passe"/>
</form>
<?php
    }
} else if ($b_success == 1) {
?>
    <p>Un email à été envoyé à l'adresse <?php echo $s_destinataire ?>.</p>
<?php
}
?>
