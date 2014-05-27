<!-- interface de gestion des fournisseurs -->
<p>
    <a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a>
</p>
<h1> Gestion des Fournisseurs </h1>

<?php
        if ($to_nom == array()) {
?>
    <p class="message"> Il n'y a aucun fournisseur défini pour l'instant </p>

<?php
        } else { 
?>
<form
action="<?php echo root ?>/fournisseur.php/gererFournisseur"
enctype ="multipart/form-data"
method = "post">
    <p><span class="form_col"><label>Ajouter un fournisseur:</label></span><input type="text" name="nom_fournisseur"/>
    <input type ="submit" value="Valider"/>
    </p>
</form>

    <table>
    <tr>
    <th>Nom</th>
    </tr>
<?php
        foreach ($to_nom as $o_val) {
?>
    <tr>
    <td><?php echo $o_val['nom'] ?></td>
    </tr>
<?php
        }
?>
    </table>
<?php
    }
?>
