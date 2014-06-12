
<div id="retour">
    <!--affiche les rayons pour que l'utilisateur puisse commander -->
    <p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>
</div>

    <h1>Commander des articles</h1>
    <?php
    /* Indique si la campagne est ouverte ou non */
    if ($b_etat == 1) {
        ?>
        <div class="indication_campagne"><span class="campagne_ouverte">Campagne ouverte</span></div>
        <?php
    } else {
        ?>
        <div class="indication_campagne"><span class="campagne_fermee">Campagne fermée</span></div>
        <?php
    }
    ?>
    <div id="list_columns">
        <?php
    if ($to_rayon != 0 and $to_rayon != array()) {
        /* Affiche les rayons s'ils existent */
        ?>
        <code><ul id="triple">
                <?php
                foreach ($to_rayon as $o_rayon) {                    
                    $tcategorie = array();
                    $bool_afficher_categorie = 0;
                    $i_nbreEnVente = 0;
                    /* Pour chaque rayon, on retient les catégories de produits présentes, on pourra ensuite les afficher */
                    foreach ($to_commande as $o_produit) {
                        if ($o_produit['en_vente'] == 1 && $o_produit['id_rayon'] == $o_rayon['id']) {
                            /* On récupère le nombre d'article présent dans chaque rayon */
                            $i_nbreEnVente ++;
                            if (!in_array($o_produit['categorie'], $tcategorie)) {
                                array_push($tcategorie, $o_produit['categorie']);
                            }
                        }
                    }
                    ?>  
                    <li> <strong> &odot; &nbsp;&nbsp;&nbsp;<a href="<?php echo root ?>/commanderArticle.php/commanderArticle?idRayon=<?php echo $o_rayon['id'] ?>"><?php echo $o_rayon['nom'] ?></a></strong></li>
                    <li> <?php
                        echo $i_nbreEnVente . ' article';
                        if ($i_nbreEnVente > 0) {
                            echo 's';
                        }
                        ?>
                    <li>                        
                        <?php
                        if ($bool_afficher_categorie == 0 and $i_nbreEnVente > 0) {
                            $bool_afficher_categorie = 1;
                            /* Si trop de catégorie, problème d'affichage sur la même ligne, on choisit donc un select à ce moment là */
                            if (count($tcategorie) > 5) {
                                ?>
                        <div id="categorie">
                        (<select>                            
                                    <?php
                                    foreach ($tcategorie as $id_categorie) {
                                        echo '<option>' . $id_categorie . '</option>';
                                    }
                                    ?>
                        </select>)</div>
                                <?php
                            } else {
                                echo '( ';
                                $i = 0;
                                foreach ($tcategorie as $id_categorie) {
                                    $i++;
                                    echo $id_categorie;
                                    if ($i < count($tcategorie)) {
                                        echo ', ';
                                    } else {
                                        echo ' )';
                                    }
                                }
                            }
                        } else {
                            echo '&nbsp';
                        }
                        ?>
                    </li>
                    <?php
                }
            } else {
                ?> 
                <p class="message">Il n'y a aucun rayon. </p>
                <?php
            }
            ?>
        </ul></code>
</div>




