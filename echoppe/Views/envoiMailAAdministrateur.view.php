<!-- interface d'envoi de mail à tous les administrateurs -->
<div id="retour">
<p>
    <a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a>
</p>
<h1>Envoyer un mail aux administrateurs</h1>
</div>
<?php
    if ($i_emailSent == 0) {
?>

    <form name="formulaire" 
    action="<?php echo root ?>/utilisateur.php/envoiMailAAdministrateur"
    enctype="multipart/form-data"
    method="post">
    
    <p><span><label>Sujet :</label></span><input type="text" name="subject" required/></p>
    <br><textarea rows ='10' cols='70' name='message'></textarea></br>
    <input type="submit" value="Envoyer">
    </form>
<?php 
    } else {
?>
    <p class="succes"> Le message a été envoyé aux administrateurs.</p>
<?php
    }
?>
