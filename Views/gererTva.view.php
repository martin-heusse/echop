 <p>
   <a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a>
</p>
<h1> Gestion des TVA </h1>

<?php
        if ($to_val == array()) {
?>
    <p class="message"> Il n'y a aucune TVA définie pour l'instant </p>

<?php
        } else { 
            if ($i_errTVA == 1) {
?>
 <p class="erreur"> Erreur : Vous ne pouvez pas ajouter une valeur de la TVA qui est déjà existante </p>
<?php
            } else if ($i_errFormat == 1) {
?>

<p class="erreur"> Erreur : Format incorrect. La TVA doit être un nombre compris entre 0 et 100. </p>
<?php
            }
?>
<form
action="<?php echo root ?>/tva.php/gererTva"
enctype ="multipart/form-data"
method = "post">
    <p><span><label>Ajouter une TVA (en %): &nbsp;</label></span><input type="text" name="id_tva"/>
    <input type ="submit" value="Valider"/>
    </p>
</form>

    <table>
    <tr>
    <th>Valeur</th>
    </tr>
<?php
        foreach ($to_val as $o_val) {
?>
    <tr>
    <td><?php echo $o_val['valeur'] ?></td>
    </tr>
<?php
        }
?>
    </table>
<?php
    }
?>
