<h1>Envoyer un mail à tous les utilisateurs</h1>

<?php
    if ($i_emailSent == 0) {
?>

    <form name="formulaire" 
    action="<?php echo root ?>/utilisateur.php/envoiMail"
    enctype="multipart/form-data"
    method="post">
    
    <p><span><label>Sujet :</label></span><input type="text" name="subject" required/></p>
    <br><textarea rows ='10' cols='70' name='message'></textarea></br>
    <input type="submit" value="Envoyer">
    </form>
<?php 
    } else {
?>
    <p> Le message a été envoyé à tous les utilisateurs.</p>
<?php
    }
?>

