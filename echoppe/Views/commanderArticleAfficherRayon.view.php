
<div id="list_columns">
    <!--affiche les rayons pour que l'utilisateur puisse commander -->
    <p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

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
    if ($to_rayon != 0 and $to_rayon != array()) {
        /* affiche les rayons s'ils existent */
        ?>
        <code><ul id="double">
                <?php
                foreach ($to_rayon as $o_rayon) {
                    $i_nbreEnVente = 0;
                    foreach ($to_commande as $o_produit) {
                        if ($o_produit['en_vente'] == 1 && $o_produit['id_rayon'] == $o_rayon['id']) {
                            $i_nbreEnVente ++;
                        }
                    }
                    ?>  
                    <li> <a href="<?php echo root ?>/commanderArticle.php/commanderArticle?idRayon=<?php echo $o_rayon['id'] ?>"><?php echo $o_rayon['nom'] ?></a></li>
                    <li> <?php echo $i_nbreEnVente . ' article';
            if ($i_nbreEnVente > 0) {
                echo 's';
            } echo ' en vente ' ?> 
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


