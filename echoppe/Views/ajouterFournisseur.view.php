<!-- Le lien de retour -->
<div id="retour">
<p>
    <a  class="action_navigation" 
        href="<?php echo root ?>/article.php/afficherArticle?i_idRayon=<?php echo $o_rayon['id'] ?>&i_pageNum=<?php echo $i_pageNum ?>">
        Retour aux articles de <?php echo $o_rayon['nom'] ?>
    </a>
</p>
</div>

<!-- Message d'erreur en cas de champ vide -->
<p>
    <?php
    if (isset($i_erreur)) {
        if ($i_erreur == 666) {
            ?>
        <p class="erreur">Erreur de saisie, le fournisseur  ou les fournisseurs n'ont pas été ajouté(s) à l'article !</p>
        <?php
    }
}
?>

<fieldset><legend>Ajouter un ou plusieurs fournisseurs à l'article "<?php echo $o_descriptionArticle['nom'] ?>"</legend>
    <form method="post" action="<?php echo root ?>/article.php/ajouterFournisseurArticle">

        <!--On envoie les variables nécessaires pour que le controleur puisse afficher cette page à nouveau en cas d'erreur-->
        <input type="hidden" name="i_idCampagne" value="<?php echo $i_idCampagne ?>">
        <input type="hidden" name="i_idRayon" value="<?php echo $i_idRayon ?>">
        <input type="hidden" name="b_historique" value="<?php echo $b_historique ?>">
        <input type="hidden" name="i_pageNum" value="<?php echo $i_pageNum ?>">
        
        
        <p><h2> Fournisseur(s) actuels : </h2>
        <?php
        $i = 0;
        $i_idArticleCampagne = $o_descriptionArticle['id_article_campagne'];
        $t_nom_fournisseur = array(); 
        ?>
        <h3>
        <?php
        /* On récupère les fournisseurs existant pour cet article */
        foreach ($to_fournisseur as $o_fournisseur) {            
            $i_idFournisseur = $o_fournisseur['id_fournisseur'];
            $o_articleFournisseur = ArticleFournisseur::getObjectByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $o_descriptionArticle[$i_idFournisseur]['code'] = $o_articleFournisseur['code'];
            $o_descriptionArticle[$i_idFournisseur]['prix_fournisseur'] = $o_articleFournisseur['prix_ht'];
            if (isset($o_articleFournisseur['prix_ht'])) {
                if ($i > 0) {
                    echo ',  ';
                }
                echo $o_fournisseur['nom_fournisseur'];
                /* On les ajoute dans un tableau */
                array_push($t_nom_fournisseur, $o_fournisseur['nom_fournisseur']);
                $i++;
            }
        }
        ?>
        </h3>
        <?php
        /* Connaissant les fournissants existants, on ne propose que les non existants */
        foreach ($t_fournisseur as $fournisseur) {      
            /* On teste que le fournisseurs n'appartient pas au tableau créé constitué des fournisseurs existants */
            if (!in_array($fournisseur['nom'], $t_nom_fournisseur)) {                
                $i_idFournisseur = $fournisseur['id'];
                ?>
                <p>
                    <!-- Les identifiant fournisseur -->
                    <input type="hidden" 
                           name="id_fournisseur_choisi" 
                           value="false"                                    
                           />
                    <!-- Les cases à cocher -->
                    <input type="checkbox" 
                           name="id_fournisseur_coche[]" 
                           value="<?php echo $i_idFournisseur; ?>" 
                           />
                    <!-- Le nom des fournisseurs -->
                    <span class="form_col"><label><?php echo $fournisseur['nom'] ?></label></span>
                    <!-- Le Code -->
                    <label>Code<sup>&nbsp;**</sup></label>
                    <input  class="input_quantite" 
                            type="text" 
                            name="code[<?php echo $i_idFournisseur; ?>]" 
                            value="" 
                            />
                    &nbsp;&nbsp;
                    <!-- Le Montant -->
                    <label>Montant<sup>&nbsp;**</sup></label>
                    <input  class="input_quantite" 
                            type="text" 
                            name="montant[<?php echo $i_idFournisseur; ?>]" 
                            value="" 
                            />
                    &euro;&nbsp;/&nbsp;
                    <!-- paquet ou unite -->
                    <select name="vente_paquet_unite[<?php echo $i_idFournisseur; ?>]">
                        <option value="1"> Paquet </option>
                        <option value="0"> Unite </option>
                    </select>
                    &nbsp;en&nbsp;
                    <!-- TTC ou HT -->
                    <select name="prix_ttc_ht[<?php echo $i_idFournisseur; ?>]">
                        <option value="0"> Prix HT </option>
                        <option value="1"> Prix TTC </option>
                    </select> .
                </p>
                <?php
            }
        }
        ?>
        <input type="hidden" name="id_article_campagne" value="<?php echo $i_idArticleCampagne ?>">
        <input type="submit" value="valider" />
    </form>
</fieldset>