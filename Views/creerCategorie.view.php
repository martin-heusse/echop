<p><a class="action_navigation" href="<?php echo root ?>/rayon.php/afficherRayon">Retour à gérer categorie</a></p>

<h1>Créer une categorie</h1>

<?php 
if ($i_categorieSet == 0) {
?>

<form name="formulaire"
action="<?php echo root ?>/categorie.php/creerCategorie"
enctype="multipart/form-data"
method="post">
    <p><span class="form_col"><label>Nom du categorie</label></span><input type="text" name="nomCategorie" required/>

<?php
    if ($i_errName == 1) {
?>
    <p class="erreur"> Erreur : Cette categorie existe déjà. </p>
<?php
    }
?>

<br/>
<br/>
    <input type="submit" value="Valider"/></p>
</form>

<?php
}
?>
