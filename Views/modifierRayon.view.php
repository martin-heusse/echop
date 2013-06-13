<h1>Modification de rayon</h1>

<?php 
    if ($i_oldRayonSet == 0) {
?>

<form name="formulaire"
action="<?php echo root ?>/rayon.php/modifierRayon"
enctype="multipart/form-data"
method="get">
    <p> Liste des rayons </p>
<?php
        foreach ($to_rayon as $o_rayon) {
?>
        <a href="<?php echo root ?>/rayon.php/modifierRayon?idRayon=<?php echo $o_rayon['id']?>"><?php echo $o_rayon['nom']?></a></br>
<?php
        }
?>

</form>

<?php
    } else {
?>

<form name="formulaire"
action="<?php echo root ?>/rayon.php/modifierRayon"
enctype="multipart/form-data"
method="post">
    <p><span class="form_col"><label>Nouveau nom du rayon</label></span><input type="text" name="newNomRayon" required/></p>
    <p><span class="form_col"><label></label></span><input type="hidden" name="idRayon" value="<?php echo $i_idRayon ?>"</p>

<?php
        if ($i_errNewName == 1) {
?>
    <p> Erreur : Ce rayon existe déjà </p>
<?php
        }
?>

    <input type="submit" value="Valider"/>
</form>
<?php
    }
?>
