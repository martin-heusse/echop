<div id="retour">
    <?php
    /* vérifie si on navigue dans l'historique ou non */
    if ($b_historique == 1) {
        ?>
        <p><a class="action_navigation" href="<?php echo root ?>/campagne.php/gererCampagne">Retour à la gestion des campagnes</a></p>
        <?php
    } else {
        ?>
        <p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>
        <?php
    }
    ?>
</div>


<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    ?>
    <span class="historique">[Historique de la campagne n°<?php echo $i_idCampagne ?>]</span>
    <?php
}

/* affiche l'ensemble des commandes utilisateurs */

if (!Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
    $i_idCampagne = Campagne::getIdCampagneCourante();
    if (Campagne::getEtat($i_idCampagne)) {
        ?>
        <h1>Articles commandés</h1>
        <?php
    } else {
        ?>
        <h1>Colisage</h1>
        <?php
    }
}
/* si on a pas d'article commandés */
if ($to_article == null or $to_article == array()) {
    ?>
    <p class="message">Aucun article n'a été commandé.</p>
    <?php
} else {
    ?>
    <?php
    if (Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
        ?>
        <p>Liste de tous les articles que vous avez commandés pendant la campagne en cours.<br/>
            <?php
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
            if (Campagne::getEtat($i_idCampagne)) {
                ?>
            <p>Liste de tous les articles que vous avez commandés pendant la campagne en cours.<br/>
            <?php } else { ?>

            <p>Vous pouvez sur cette page compléter les commandes d'articles effectuées lors de la campagne.<br/>     
                <?php
            }
        }
        /* l'affichage diffère si on est un administrateur ou non
         * un administrateur peut accèder à des pages annexes à partir de celle-ci 
         * contrairement aux simples utilisateurs */
        if (Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
            ?>
            Cliquez sur l'un des articles pour voir la liste de tous les utilisateurs l'ayant commandé.</p>
        <?php
    }
    /* tableau d'affichage des résultats, les colonnes diffèrent en fonction du 
     * status de l'utilisateur */
    ?>

    <p>
        <span class="cat_bouton cacher_tout">Cacher tout</span> |
        <span class="cat_bouton montrer_tout">Montrer tout</span> 
    </p>
    <?php
    if (!Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
        ?>
        <form method="post" action="articlesCommandEs.php/forceUtilisateur?idCampagne=<?php echo $i_idCampagne ?>"
              >
            <input type="hidden" name="forceUtilisateur" value="<?php echo $_SESSION['idUtilisateur'] ?>"
                   <p>

                <?php
            }
            ?>
        <table>
            <thead><!-- En tête du tableau -->
                <tr class='tab_article'>
                    <th>Article</th>

                    <?php
                    if (Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
                        ?>
                        <th>Commandé <br/> par vous</th>
                        <th>Quantité totale commandée</th>
                        <th>Colisage</th>
                        <?php
                    }
                    ?>
                    <th>Manque</th>
                    <?php
                    $i_idCampagne = Campagne::getIdCampagneCourante();
                    if (!Administrateur::isAdministrateur($_SESSION['idUtilisateur']) and !Campagne::getEtat($i_idCampagne)) {
                        ?>
                    <th>Quantité</th>
                    <th>Valider</th>
                    <?php }
                    ?>
                </tr>
            </thead>
            <tbody class="tab_article">
                <?php
                $i_numLigne = 0;
//print_r($to_article);
                //Mise en place d'une variable catégorie pour classer les articles en fonction 
                $to_categorie = Categorie::getAllObjects();


                foreach ($to_categorie as $o_categorie) {
                    $i_nbreArticleCategorie = 0;
                    foreach ($to_article as $o_article) {
                        if (Article::getIdCategorie($o_article['id_article']) == $o_categorie['id']) {
                            $i_nbreArticleCategorie++;
                        }
                    }

                    if ($i_nbreArticleCategorie != 0) {
                        ?>
                        <tr><td>
                                <span class="cat"><?php echo $o_categorie['nom'] ?></span><div id="right">&nbsp;&nbsp;
                                    <span class="cat_bouton2 cacher_<?php echo $o_categorie['id'] ?>">Cacher </span>|  
                                    <span class="cat_bouton2 montrer_<?php echo $o_categorie['id'] ?>"> Montrer</span> 
                                </div></td></tr>

                        <?php
                        foreach ($to_article as $o_article) {
                            if (Article::getIdCategorie($o_article['id_article']) == $o_categorie['id']) {
                                ?>


                                <tr class="ligne_article<?php echo $i_numLigne ?> cat_<?php echo $o_categorie['id'] ?>">

                                    <td class="center">
                                        <?php
                                        if (Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
                                            ?>
                                            <a href="<?php echo root ?>/articlesCommandEs.php/utilisateursAyantCommandECetArticle?idArticle=<?php echo $o_article['id_article'] ?>
                                            <?php
                                            /* Si navigation dans l'historique */
                                            if ($b_historique == 1) {
                                                echo "&idOldCampagne=" . $i_idCampagne;
                                            }
                                            ?>
                                               ">
                                                   <?php
                                               }
                                               echo $o_article['nom'];
                                               if (Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
                                                   ?></a>
                                        <?php }
                                        ?>
                                    </td>
                                    <?php
                                    if (Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
                                        ?>
                                        <td class="center">
                                            <?php if ($o_article['commandeParUtilsateurCourant']) echo $o_article['commandeParUtilsateurCourant'] . " unité(s)"; ?> 
                                        </td>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if (Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
                                        ?>
                                        <td class="centrer"><?php echo $o_article['quantite_totale'] . $o_article['unite'] . " (" . $o_article['quantite_totale_unites'] . " unités)" ?></td>
                                        <td class="centrer">multiple de <?php echo $o_article['colisage'] . $o_article['unite'] ?></td>
                                        <?php
                                    }
                                    if ($o_article['manque'] != 0) {
                                        ?> 
                                        <td class="centrer col_coloree"> 
                                            <strong> 
                                                <?php echo $o_article['manque_unite'] . " unité(s)" . " (" . $o_article['manque'] . $o_article['unite'] . ")" ?></strong>
                                            <?php
                                        } else {
                                            ?>
                                        <td class="centrer"><?php
                                            echo $o_article['manque'] . $o_article['unite'];
                                        }
                                        ?>

                                    </td>
                                    <?php
                                    $i_idCampagne = Campagne::getIdCampagneCourante();
                                    if (!Administrateur::isAdministrateur($_SESSION['idUtilisateur']) and !Campagne::getEtat($i_idCampagne) ) {

                                        if (!$o_article['manque_unite'] > 0) {
                                            ?>
                                            <td></td>
                                            <td></td>
                                        <?php } else {
                                            ?>
                                            <td><center>
                                        <select name="forceQuantite_<?php echo $o_article['id_article'] ?>">
                                            
                                            <?php
                                            $i = 0;
                                            while ($i < $o_article['manque_unite'] + 1) {
                                                ?>
                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    </center>
                                    </td> 
                                    <td><center><input type="submit" name="idArticle_<?php echo $o_article['id_article'] ?>" value="✓" style="color: green; font-weight: bold"/></center></td>
                                        <?php
                                    }
                                }
                                ?>
                            </tr>
                            <?php
                            $i_numLigne = ($i_numLigne + 1) % 2;
                        }
                    }
                }
            }
            ?>
            </tbody>

        </table>  
    </form>

    <?php
}
foreach ($to_categorie as $o_categorie) {
    ?>
    <script type="text/javascript">
        $(".cacher_<?php echo $o_categorie['id'] ?>").click(function() {
            $(".cat_<?php echo $o_categorie['id'] ?>").hide("slow");
        });
    </script>
    <script type="text/javascript">
        $(".montrer_<?php echo $o_categorie['id'] ?>").click(function() {
            $(".cat_<?php echo $o_categorie['id'] ?>").show("slow");
        });
    </script>

    <?php
}
?>
<script type="text/javascript">
    cacher_tout = function() {
        $(".ligne_article0").hide(0);
        $(".ligne_article1").hide(0);
    }
// 
// window.onload = cacher_tout;
// 
    $(".cacher_tout").click(function() {
        cacher_tout();
    });
    $(".montrer_tout").click(function() {
        $(".ligne_article0").show(0);
        $(".ligne_article1").show(0);
    });
</script>

