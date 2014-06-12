<!-- affiche la liste des personnes qui se sont inscrites mais qui ne sont pas encore validées-->
<div id="retour">
    <p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>
</div>
<h1>Liste des désinscriptions d'utilisateurs à valider</h1>

<p>
    <?php
    if ($to_utilisateur != null) {
        ?> 
    <table>
        <tr>
            <th> Nom </th>
            <th> Prénom </th>
            <th> Valider</th>
        </tr>
        <?php
        foreach ($to_utilisateur as $o_utilisateur) {
            ?>
            <tr>
            <form action="<?php echo root ?>/inscription.php/desinscription" enctype="multipart/form-data" method="post" name="formulaire">
                <td><?php echo $o_utilisateur['nom'] ?> </td>
                <td><?php echo $o_utilisateur['prenom'] ?> </td>

                <input type="hidden" name = id_utilisateur_a_suppr value="<?php echo $o_utilisateur['id'] ?>" >
                <input type="hidden" name = page value="listeUtilisateurADesinscrire" >
                <td > <center><input type="image" id='SUBMIT' value="Supprimer" src="<?php echo root ?>/Layouts/images/cross.png" height='25'></center></td>
                </tr>
                <?php
            }
            ?>
    </table>
    <?php
} else {
    ?>
    <p class="message"> Il n'y a aucune desinscription à valider</p>
    <?php
}
?>
