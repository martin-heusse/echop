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
?>

<form
name="formulaire"
action="<?php echo root ?>/rayon.php/modifierRayon"
enctype="multipart/form-data"
method="post">
    <p><label>Nouveau nom du rayon</label>&nbsp&nbsp<input type="text" name="newNomRayon" required/>
    <input type="hidden" name="idRayon" value="<?php echo $i_idRayon ?>"/>

<?php
        if ($i_errNewName == 1) {
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
