<!-- interface de désinscription -->
<?php
if (Utilisateur::isLogged() && Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
    ?>
    <h1> Suppression d'un article </h1>
    <?php
}
?>

<center><img src="<?php echo root ?>/Layouts/images/warning.png" height="150" alt="<?php echo $titre_page ?>" />

    <?php
    if (Utilisateur::isLogged() && Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
        ?>
        <p><h3>Etes-vous bien sûr de vouloir supprimer cet article  ?</h3></p>
    <?php
}
?>
<form action="<?php echo root ?>/article.php/supprimerArticle" enctype="multipart/form-data" method="post" name="formulaire">
    <input type="radio" name="confirm" value="1"/> Oui 
    <input type="radio" name="confirm" value="0" /> Non
    <input type="hidden" name='id_article' value='<?php echo $id_article ?>' >
    <input type="hidden" name='i_idRayon' value='<?php echo $i_idRayon ?>' >
    <input type="hidden" name='i_pageNum' value='<?php echo $i_pageNum ?>' >
    <p><input type="submit" value="Valider"/></p>
</form>
</center>
    <?php

