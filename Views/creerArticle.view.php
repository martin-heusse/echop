<?php
    //Trace
    //var_dump($to_unite);
    //return;
?>

<form action="<?php echo root ?>/article.php/creerArticle" method="post" name="formulaire">
    <p><a class="action_navigation" href="<?php echo root ?>/article.php/afficherArticle">Retour</a>
<?php
if(isset($i_erreur)){
    if($i_erreur==0){
        echo "Votre article a été crée !";
    }
    if($i_erreur==1){
        echo "Erreur de saisie, l'article n'a pas été crée !";
    }
}
?>
    </p>
    <fieldset><legend>Créer un article</legend>
        <p>Les Champs avec * sont obligatoires.</p>
        <p><span class="form_col"><label>Produit<sup>&nbsp *</sup></label></span><input type="text" name="nom_produit" value=""/></p>
        <p><span class="form_col"><label>Description courte</label></span><input type="text" name="description_courte" value=""/></p>
        <p><span class="form_col"><label>Description longue</label></span><input type="text" name="description_longue" value=""/></p>
        <p><span class="form_col"><label>Poids du paquet fournisseur</label></span><input type="text" name="poids_paquet_fournisseur" value=""/></p>
        <p><span class="form_col"><label>Poids du paquet client</label></span><input type="text" name="poids_paquet_client" value=""/></p>
        <!-- choix multiple unité -->
        <p><span class="form_col"><label>Unité</label></span><select name="id_unite">
<?php foreach($to_unite as $o_unite){
?>
        <option value="<?php echo $o_unite['id'] ?>"><?php echo $o_unite['valeur'] ?></option>
<?php
}
?>
        </select></p> <!-- fin de choix muliple unite -->
        <p><span class="form_col"><label>Nombre de paquets par colis fournisseur</label></span><input type="text" name="nb_paquet_colis" value=""/></p>
        <p><span class="form_col"><label>Seuil min</label></span><input type="text" name="seuil_min" value=""/></p>
        <!-- fournisseurs  -->
        <h5> Liste des fournisseurs </h5>
<?php
// cocher le premier fournisseur
$estChoisi = TRUE;
foreach($to_fournisseur as $o_fournisseur){
?>
        <p>
            <span class="form_col"><label><?php echo $o_fournisseur['nom']; ?></label></span>
            <input type="hidden" name="id_fournisseur[]" value="<?php echo $o_fournisseur['id']; ?>"/>
            <label>Code</label><input type="text" name="code[]" value=""/>
            <label>Prix TTC</label><input type="text" name="prix_ttc_fournisseur[]" value=""/>
            <label>Prix HT</label><input type="text" name="prix_ht[]" value=""/>
            <label>Choisir</label><input type="radio" name="id_fournisseur_choisi" value="<?php echo $o_fournisseur['id']; ?>" <?php if($estChoisi){$estChoisi = null; echo 'checked="true"';} ?>/>
        </p>
<?php
}
?>
        <!-- tva à choisir -->
        <p><span class="form_col"><label>TVA</label></span><select name="id_tva">
<?php foreach($to_tva as $o_tva){
?>
        <option value="<?php echo $o_tva['id'] ?>"><?php echo $o_tva['valeur'] ?></option>
<?php
}
?>
        </select></p>
        <p><span class="form_col"><label>Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client</label></span><input type="text" name="prix_ttc_echoppe" value=""/></p>
        <!-- Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client à calculer -->
        <p><span class="form_col"><label>Prix TTC rapporté à l'unité echoppe</label></span><input type="text" value="A CALCULER JS" disabled="disabled"/></p>
        <input type="submit" value="valider" />
    </fieldset>
</form>
