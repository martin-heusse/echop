<h1>Envoi de mail</h1>

<?php
    if ($i_emailSent == 0) {
?>

    <form name="formulaire" 
    action="<?php echo root ?>/utilisateur.php/envoiMail"
    enctype="multipart/form-data"
    methode="post">
    
    <p><span class="form_col"><label>Sujet :</label></span><input type="text" name="subject" required/></p>
    <br><textarea rows ='10' cols='70' name='message'></textarea></br>
    </form>
    <input type="submit" value="Envoyer">
<?php 
    } else {
?>
    <p> Le message a été envoyé à tous les utilisateurs </p>
<?php
    }
?>

    <p> emailSent = <?php echo $i_emailSent;?></p>
    <p> fake = <?php echo $fake; ?></p>
