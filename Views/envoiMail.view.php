<h1>Envoi de mail</h1>

<?php
    if ($i_emailSent == 0) {
?>

    <form name="formulaire" 
    action="<?php echo root ?>/utilisateur.php/envoiMail"
    enctype="multipart/form-data"
    methode="post">
    
    <p><span class="form_col"><label>Sujet :</label></span><input type="text" name="subject" required/></p>
    <br><textarea rows ='10' cols='80' name='message'>Message:</textarea></br>
    </form>

<?php 
    } else {
?>
    <p> Le message a été envoyé à tous les utilisateurs </p>
<?php
    }
?>
