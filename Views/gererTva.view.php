<h1> Gestion des TVA </h1>

<?php
        if ($to_val == array()) {
?>
    <p> Il n'y a aucune TVA définie pour l'instant </p>

<?php
        } else { 
?>
<form
action="<?php echo root ?>/tva.php/gererTva"
enctype ="multipart/form-data"
method = "post">
    <p><span class="form_col"><label>Ajouter une TVA:</label></span><input type="text" name="id_tva"/>
    <input type ="submit" value="Valider"/>
    </p>
</form>

<p>
    <table>
    <tr>
    <th>Valeur</th>
    <th>Modifier</th>
    </tr>
<?php
        foreach ($to_val as $o_val) {
?>
    <tr>
    <td><?php echo $o_val['valeur'] ?></td>
    <td><a href="<?php echo root ?>/tva.php/supprimerTva?tva=<?php echo $o_val['id'] ?>">Supprimer</a></td>
    </tr>
<?php
        }
?>
    </table>
</p>
<?php
        }
?>
