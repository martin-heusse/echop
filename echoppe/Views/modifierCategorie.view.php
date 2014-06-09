<!-- interface de modification d'une catégorie-->
<div id="retour">
<p><a class="action_navigation" href="<?php echo root ?>/rayon.php/afficherRayon">Retour à gérer categorie</a></p>
</div>
<h1>Modifier un categorie</h1>

<?php 
    if ($i_oldCategorieSet == 0) {
?>

<form
name="formulaire"
action="<?php echo root ?>/categorie.php/modifierCategorie"
enctype="multipart/form-data"
method="get">
    <p> La liste des categories  : </p>
<ul>
<?php
        foreach ($to_categorie as $o_categorie) {
?>
        <li><a href="<?php echo root ?>/categorie.php/modifierCategorie?idCategorie=<?php echo $o_categorie['id']?>"><?php echo $o_categorie['nom']?></a></li>
<?php
        }
?>
</ul>
</form>

<?php
    } else {

        if ($i_errNewName == 1) {
?>
    <p class="erreur"> Erreur : Cette categorie existe déjà </p>

<form 
name="formulaire"
action="<?php echo root ?>/categorie.php/modifierCategorie"
enctype="multipart/form-data"
method="post">
    <p> Nom actuel : <?php echo $s_Categorie ?> </p>
    <p><span class="form_col"><label>Nouveau nom de la categorie</label></span><input type="text" name="newNomCategorie"/></p>
    <p><span class="form_col"></span><input type="hidden" name="idCategorie" value="<?php echo $i_idCategorie ?>"</p>

<?php
        } else {
?>

<form
name="formulaire"
action="<?php echo root ?>/categorie.php/modifierCategorie"
enctype="multipart/form-data"
method="post">
    <p> Nom actuel : <?php echo $s_Categorie ?> </p>
    <p><span class="form_col"><label>Nouveau nom de la categorie</label></span><input type="text" name="newNomCategorie"/></p>
    <p><span class="form_col"></span><input type="hidden" name="idCategorie" value="<?php echo $i_idCategorie ?>"</p>

<?php
        }
?>

    <input type="submit" value="Valider"/></p>
</form>
<?php
    }
?>
