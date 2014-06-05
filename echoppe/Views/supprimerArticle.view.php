<!-- interface de désinscription -->
<?php
if (Utilisateur::isLogged() && Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
    ?>
    <h1> Suppression d'un article </h1>
    <?php
} 
?>
<?php
if (Utilisateur::isLogged() && Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
    ?>
    <p>Etes-vous bien sûr de vouloir supprimer cet article  ?</p>
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

    <?php

