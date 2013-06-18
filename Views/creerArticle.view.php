<form action="<?php echo root ?>/article.php/creerArticle?i_idRayon=<?php echo $o_rayon['id']?>" method="post" name="formulaire">
    <!-- Le lien de retour -->
    <p><a class="action_navigation" href="<?php echo root ?>/article.php/afficherArticle?i_idRayon=<?php echo $o_rayon['id']?>">Retour aux articles de <?php echo $o_rayon['nom']?></a>
<?php
/* Gestion des erreurs A FAIRE */
if(isset($i_erreur)){
    if($i_erreur==0){
        echo "Votre article a été crée !";
    }
    if($i_erreur==1){
?>
<p class="erreur"> Erreur de saisie, l'article n'a pas été crée ! </p>
<?php
    }
}
?>
    </p>
    <!-- Message de consignes -->
    <fieldset><legend>Créer un article</legend>
        <h3> Vous allez créer un article dans <?php echo $o_rayon['nom']?> </h3>
        <p>Les Champs avec * sont obligatoires. Si vous ne voulez rien mettre mettez un tiret.</p>
        <!-- Rayon choisi en variable cachée -->
        <input  type="hidden"
                name="id_rayon"
                value="<?php echo $o_rayon['id']?>"
        />
        <p> <!-- Nom du Produit à choisir-->
            <span class="form_col"><label>Produit<sup>&nbsp *</sup></label></span>
            <input  type="text"  
                    name="nom_produit" 
                    value=""
            />
        </p>
        <p> <!-- Liste des catégories à choisir -->
            <span class="form_col"><label>Categorie</label></span>
            <select name="id_categorie">
<?php foreach($to_categorie as $o_categorie){
?>
                <option value="<?php echo $o_categorie['id'] ?>"><?php echo $o_categorie['nom'] ?></option>
<?php
}
?>
            </select>
        </p> 
        <p> <!-- Description courte à choisir-->
            <span class="form_col"><label>Description courte</label></span>
            <input  type="text" 
                    name="description_courte" 
                    value=""
             />
        </p>
        <p> <!-- Description longue à choisir-->
            <span class="form_col"><label>Description longue</label></span>
            <input  type="text" 
                    name="description_longue" 
                    value=""
             />
        </p>
        <p> <!-- Poids du paquet fournisseur à choisir-->
            <span class="form_col"><label>Poids du paquet fournisseur</label></span>
            <input  type="text" 
                    name="poids_paquet_fournisseur" 
                    value=""
             />
        </p>
        <p> <!-- Poids du paquet client à choisir-->
            <span class="form_col"><label>Poids du paquet client</label></span>
            <input  type="text" 
                    name="poids_paquet_client" 
                    value=""
            />
        </p>
        <p> <!-- Liste des unités à choisir -->
            <span class="form_col"><label>Unité</label></span>
            <select name="id_unite">
<?php foreach($to_unite as $o_unite){
?>
                <option value="<?php echo $o_unite['id'] ?>"><?php echo $o_unite['valeur'] ?></option>
<?php
}
?>
            </select>
        </p>
        <p>  <!-- Nombre de paquets par colis fournisseur à choisir -->
            <span class="form_col"><label>Nombre de paquets par colis fournisseur</label></span>
            <input  type="text" 
                    name="nb_paquet_colis" 
                    value=""
            />
        </p>
        <p> <!-- Seuil min à choisir -->
            <span class="form_col"><label>Seuil min</label></span>
            <input  type="text" 
                    name="seuil_min" 
                    value=""
            />
        </p>
        <p> <!-- Tva à choisir -->
            <span class="form_col"><label>TVA</label></span>
                <select name="id_tva">
<?php foreach($to_tva as $o_tva){
?>
        <option value="<?php echo $o_tva['id'] ?>"><?php echo $o_tva['valeur'] ?></option>
<?php
}
?>
            </select>
        </p>
        <h5> Liste des fournisseurs </h5>         <!-- Liste des fournisseurs  à choisir -->
<?php
// cocher le premier fournisseur
$estChoisi = TRUE;
foreach($to_fournisseur as $o_fournisseur){
?>
        <p>
            <input type="checkbox" name="id_fournisseur[]" value="<?php echo $o_fournisseur['id']; ?>"> 
            <span class="form_col"><label><?php echo $o_fournisseur['nom']; ?></label></span>
            <!--<input type="hidden" name="id_fournisseur[]" value="<?php echo $o_fournisseur['id']; ?>"/> -->
            <label>Code</label><input type="text" name="code[]" value=""/>
            <label>Prix TTC</label><input type="text" name="prix_ttc_fournisseur[]" value=""/>
            <label>Prix HT</label><input type="text" name="prix_ht[]" value=""/>
            <label>Choisir</label><input type="radio" name="id_fournisseur_choisi" value="<?php echo $o_fournisseur['id']; ?>" <?php if($estChoisi){$estChoisi = null; echo 'checked="true"';} ?>/>
        </p>
<?php
}
?>
        <p> <!--Prix client TTC calculer de façon automatique -->
            <span class="form_col"><label>Prix client TTC</label></span>
            <input type="text" 
                   name="prix_ttc_echoppe" 
                   value=""
                   disabled
            />
        </p>
        <p> <!-- Prix client unitaire TTC calculé de façon automatique -->
            <span class="form_col"><label>Prix client unitaire TTC</label></span>
            <input type="text" 
                   value="" 
                   disabled
            />
        </p>
        <input type="submit" value="valider" />
    </fieldset>
</form>
