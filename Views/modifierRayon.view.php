<p><a class="action_navigation" href="<?php echo root ?>/rayon.php/afficherRayon">Retour</a></p>

<h1>Modifier un rayon</h1>

<?php 
    if ($i_oldRayonSet == 0) {
?>

<form
name="formulaire"
action="<?php echo root ?>/rayon.php/modifierRayon"
enctype="multipart/form-data"
method="get">
    <p> La liste des rayons  : </p>
<ul>
<?php
        foreach ($to_rayon as $o_rayon) {
?>
        <li><a href="<?php echo root ?>/rayon.php/modifierRayon?idRayon=<?php echo $o_rayon['id']?>"><?php echo $o_rayon['nom']?></a></li>
<?php
        }
?>
</ul>
</form>

<?php
    } else {

        if ($i_errNewName == 1) {
?>
    <p> Erreur : Ce rayon existe déjà </p>
<form 
name="formulaire"
action="<?php echo root ?>/rayon.php/modifierRayon"
enctype="multipart/form-data"
method="post">
    <p> Ancien nom : <?php echo $s_nomRayon ?> </p>
    <p><span class="form_col"><label>Nouveau nom du rayon</label></span><input type="text" name="newNomRayon" required/></p>
    <p><span class="form_col"></span><input type="hidden" name="idRayon" value="<?php echo $i_idRayon ?>"</p>

<?php
        } else {
?>
<form
name="formulaire"
action="<?php echo root ?>/rayon.php/modifierRayon"
enctype="multipart/form-data"
method="post">
    <p> Ancien nom : <?php echo $s_Rayon ?> </p>
    <p><span class="form_col"><label>Nouveau nom du rayon</label></span><input type="text" name="newNomRayon" required/></p>
    <p><span class="form_col"></span><input type="hidden" name="idRayon" value="<?php echo $i_idRayon ?>"</p>

<?php
        }
?>

    <input type="submit" value="Valider"/></p>
</form>
<?php
    }
?>
