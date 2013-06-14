<p><a class="action_navigation" href="<?php echo root ?>/rayon.php/afficherRayon">Retour</a></p>

<h1>Créer un rayon</h1>

<?php 
    if ($i_rayonSet == 0) {
?>

<form name="formulaire"
action="<?php echo root ?>/rayon.php/creerRayon"
enctype="multipart/form-data"
method="post">
    <p><span class="form_col"><label>Nom du rayon</label></span><input type="text" name="nomRayon" required/>

<?php
        if ($i_errName == 1) {
?>
    <p> Erreur : Ce rayon existe déjà </p>
<?php
        }
?>

    <input type="submit" value="Valider"/></p>
</form>

<?php
    }
?>
