<!-- affiche la liste des utilisateurs avec le login et l'adresse mail -->
<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Liste de tous les utilisateurs</h1>

<a href="<?php echo root ?>/utilisateur.php/ajouterUtilisateur">Créer un nouvel utilisateur</a>

<p>

    <?php
    if ($to_utilisateur != null) {
        ?> 
    <table >
        <tr>
            <th><center> Login </center></th>
            <th><center> Nom </center></th>
            <th><center> Prénom </center></th>
            <th><center> Adresse Mail </center></th>            
            <!--<th>  </th>-->
        <tr/>
        <?php
        foreach ($to_utilisateur as $o_utilisateur) {
            ?>
            <tr>
            <form action="<?php echo root ?>/inscription.php/desinscription" enctype="multipart/form-data" method="post" name="formulaire">
                <td><center>  <?php echo $o_utilisateur['login'] ?> </center></td>
                <td><center>  <?php echo $o_utilisateur['nom'] ?> </center></td> 
                <td><center>  <?php echo $o_utilisateur['prenom'] ?> </center></td>
                <td><center>  <?php echo $o_utilisateur['email'] ?> </center></td>                
                <input type='hidden' name='id_utilisateur_a_suppr' value='<?php echo $o_utilisateur['login'] ?>'>
                <td height="30" width="25"> <center><input type="image" id='SUBMIT' value="Supprimer" src="<?php echo root ?>/Layouts/images/cross.png" height='13'></center></td>

            </form>
        </tr>
        <?php
    }
    ?>
    </table> 

    <?php
} else {
    ?>
    <p class="message"> Il n'y a aucun utilisateur inscrit</p>
    <?php
}
?>