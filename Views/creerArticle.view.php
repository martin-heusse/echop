<form action="<?php echo root ?>/article.php/creerArticle" method="post" name="formulaire">
<p><a class="action_navigation" href="<?php echo root ?>/rayon.php/afficherRayon">Retour</a>
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
        <p><span class="form_col"><label>Poids du paquet fournisseur</label></span><input type="text" name="poids_paquet_fournisseur" value=""/></p>
        <p><span class="form_col"><label>Poids du paquet client</label></span><input type="text" name="poids_paquet_client" value=""/></p>
        <!-- unité à choisir choix multiple A FAIRE -->
        <p><span class="form_col"><label>Unité</label></span><input type="text" name="id_unite" value="1"/></p>
        <p><span class="form_col"><label>Nombre de paquets par colis fournisseur</label></span><input type="text" name="nb_paquet_colis" value=""/></p>
        <p><span class="form_col"><label>Seuil min</label></span><input type="text" name="seuil_min" value=""/></p>
        <!-- les fournisseurs à choisir A FAIRE -->
        <p>
            <span class="form_col"><label>Fournisseur </label></span><input type="text" name="id_fournisseur" value="1"/>
            <span class="form_col"><label>Code</label></span><input type="text" name="code" value=""/>
            <span class="form_col"><label>Prix TTC</label></span><input type="text" name="prix_ttc_fournisseur" value=""/>
            <span class="form_col"><label>Prix HT</label></span><input type="text" name="prix_ht" value=""/>
        </p>
        <p><span class="form_col"><label>TVA</label></span><input type="text" name="id_tva" value="1"/></p>
        <p><span class="form_col"><label>Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client</label></span><input type="text" name="prix_ttc_echoppe" value=""/></p>
        <p><span class="form_col"><label>Prix TTC rapporté à l'unité echoppe</label></span><input type="text" value="A CALCULER"/></p>
        <!-- la tva à choisir A FAIRE -->
        <!-- Prix TTC choisi par l'échoppe rapporté au colis du fournisseur vendu au client à calculer -->
        <p><span class="form_col"><label>Description courte</label></span><input type="text" name="description_courte" value=""/></p>
        <p><span class="form_col"><label>Description longue</label></span><input type="text" name="description_longue" value=""/></p>
        <input type="submit" value="valider" />
    </fieldset>
</form>
