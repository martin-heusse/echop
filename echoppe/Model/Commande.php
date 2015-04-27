<?php

class Commande {
    /* Getter clé primaire */

    public static function getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur) {
        $sql_query = "select id from commande where id_article=$i_idArticle and id_campagne=$i_idCampagne and id_utilisateur=$i_idUtilisateur";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id'], null, 'UTF-8');
        }
        return $i_result;
    }

    /* Creaters */

    public static function create($i_idArticle, $i_idCampagne, $i_idUtilisateur, $i_quantite, $b_estLivre = 0) {
        $sql_query = "insert into commande(id_article, id_campagne, 
                id_utilisateur, quantite, est_livre) 
                values('$i_idArticle', '$i_idCampagne', '$i_idUtilisateur', '$i_quantite', '$b_estLivre')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from commande";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getCodeFournisseurByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur) {
        $sql_query = "select * from commande where id_article=$i_idArticle and id_campagne=$i_idCampagne and id_utilisateur=$i_idUtilisateur";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getObjectsByIdArticle($i_idArticle) {
        $sql_query = "select * from commande where id_article=$i_idArticle";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getObjectsByIdCampagne($i_idCampagne) {
        $sql_query = "select * from commande where id_campagne=$i_idCampagne";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getObjectsByIdUtilisateur($i_idUtilisateur) {
        $sql_query = "select * from commande where id_utilisateur=$i_idUtilisateur";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getObjectsByIdArticleIdCampagne($i_idArticle, $i_idCampagne) {
        $sql_query = "select c.* from commande c, utilisateur u where c.id_article=$i_idArticle and c.id_campagne=$i_idCampagne and c.id_utilisateur=u.id order by u.login";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getObjectsNotOrderedByIdArticleIdCampagne($i_idArticle, $i_idCampagne) {
        $sql_query = "select u.id, u.login, du.nom, du.prenom from utilisateur u, datasUtilisateur du where u.id=du.id and u.id not in (select id_utilisateur from commande where id_article=$i_idArticle and id_campagne=$i_idCampagne) order by login;";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getCountByEstLivreForIdCampagneIdUtilisateur($b_estLivre, $i_idCampagne, $i_idUtilisateur) {
        $sql_query = "select count(*) number from commande where est_livre=$b_estLivre and id_campagne=$i_idCampagne and id_utilisateur=$i_idUtilisateur";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['number'], null, 'UTF-8');
        }
        return $i_result;
    }

    public static function getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne) {
        $sql_query = "select distinct c.id_utilisateur from commande c , utilisateur u where c.id_article=$i_idArticle and c.id_campagne=$i_idCampagne and c.id_utilisateur=u.id order by u.login";
        $sql_tmp = mysql_query($sql_query);
        $ti_result = array();
        while ($i_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($i_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $ti_result[] = $i_row['id_utilisateur'];
        }
        return $ti_result;
    }

    public static function getIdArticleByIdCampagne($i_idCampagne) {
        $sql_query = "select distinct id_article from commande where id_campagne=$i_idCampagne";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getIdArticleByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur) {
        $sql_query = "select distinct id_article from commande where id_campagne=$i_idCampagne and id_utilisateur=$i_idUtilisateur";
        $sql_tmp = mysql_query($sql_query);
        $ti_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $ti_result[] = $o_row;
        }
        return $ti_result;
    }

    public static function getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur) {
        $sql_query = "select com.*, r.nom as nom_rayon from commande com, rayon r , article a  where com.id_campagne=$i_idCampagne and com.id_utilisateur=$i_idUtilisateur and com.id_article=a.id and r.id=a.id_rayon order by a.id_rayon, a.id";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as $nom_col => &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getObject($i_id) {
        $sql_query = "select * from commande where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getIdUtilisateurUniqueByIdCampagne($i_idCampagne) {
        $sql_query = "select distinct c.id_utilisateur from commande c  ,utilisateur u, datasUtilisateur dat where c.id_campagne=$i_idCampagne and c.id_utilisateur=u.id and dat.id=u.id order by dat.nom,dat.prenom";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getIdArticle($i_id) {
        $sql_query = "select id_article from commande where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_article'], null, 'UTF-8');
        }
        return $i_result;
    }

    public static function getIdCampagne($i_id) {
        $sql_query = "select id_campagne from commande where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_campagne'], null, 'UTF-8');
        }
        return $i_result;
    }

    public static function getIdUtilisateur($i_id) {
        $sql_query = "select id_utilisateur from commande where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_utilisateur'], null, 'UTF-8');
        }
        return $i_result;
    }

    public static function getQuantite($i_id) {
        $sql_query = "select quantite from commande where id=$i_id";
        $sql_tmp = mysql_query($sql_query);

        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['quantite'], null, 'UTF-8');
        }
        return $i_result;
    }

    public static function getQuantiteByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur) {
        $sql_query = "select quantite from commande where id_article=$i_idArticle and id_campagne=$i_idCampagne and id_utilisateur=$i_idUtilisateur";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['quantite'], null, 'UTF-8');
        }
        return $i_result;
    }

    public static function getEstLivre($i_id) {
        $sql_query = "select est_livre from commande where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $b_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $b_result = htmlentities($o_row['est_livre'], null, 'UTF-8');
        }
        return $b_result;
    }

    public static function getExportCSVDatas($i_idUtilisateur, $i_idCampagne) {
        $sql_query = "select a.nom, a.description_courte, aF.code as Code_Fournisseur, a.poids_paquet_fournisseur, a.nb_paquet_colis, aC.prix_ttc,(aC.prix_ttc/a.poids_paquet_fournisseur) as Prix_TTC_Unitaire, aC.seuil_min, c.quantite, (c.quantite*aC.poids_paquet_client) as Quantite_Totale_Commandee,(c.quantite*aC.poids_paquet_client*aC.prix_ttc/a.poids_paquet_fournisseur) as Prix_Total_TTC
                        from article a, article_campagne aC, commande c, utilisateur u, article_fournisseur aF
                        where a.id=aC.id_article and aC.id_article=c.id_article and aF.id_article_campagne=aC.id and aF.id_fournisseur=aC.id_fournisseur and aC.id_campagne=c.id_campagne and c.id_campagne=$i_idCampagne and c.id_utilisateur=u.id and u.id=$i_idUtilisateur";
        return $sql_query;
    }

    public static function getExportCSVTotalTTC($i_idUtilisateur, $i_idCampagne) {
        $sql_query = "select sum(c.quantite*aC.poids_paquet_client*aC.prix_ttc/a.poids_paquet_fournisseur) as Prix_Total_TTC
                        from article a, article_campagne aC, commande c, utilisateur u
                        where a.id=aC.id_article and aC.id_article=c.id_article and aC.id_campagne=c.id_campagne and c.id_campagne=$i_idCampagne and c.id_utilisateur=u.id and u.id=$i_idUtilisateur";
        return $sql_query;
    }

    public static function getExportCSVFournisseur($i_idFournisseur, $i_idCampagne) {
        $sql_query = "select af.code, a.nom as Nom, SUM(c.quantite) as Quantite, u.valeur as Unite, af.prix_ht as Prix_HT_Paquet, SUM(c.quantite)*ac.poids_paquet_client*af.prix_ttc/a.poids_paquet_fournisseur as Prix_Total_TTC
                        from article_fournisseur af, article a, commande c, article_campagne ac, unite u, campagne ca
                        where a.id=ac.id_article and af.id_article_campagne=ac.id and u.id=a.id_unite and ca.id=ac.id_campagne and ac.id_fournisseur=af.id_fournisseur and c.id_article=a.id and c.id_campagne=ca.id and ac.id_fournisseur=$i_idFournisseur and ca.id=$i_idCampagne
                        group by a.nom, a.poids_paquet_fournisseur";
        return $sql_query;
    }

    public static function getExportCSVTotalTTCFournisseur($i_idFournisseur, $i_idCampagne) {
        $sql_query = "select SUM(Prix_Total_TTC.Prix_TTC) as Montant_Total_Fournisseur
                            From (select SUM(c.quantite)*ac.poids_paquet_client*af.prix_ttc/a.poids_paquet_fournisseur as Prix_TTC
                                     from article_fournisseur af, article a, commande c, article_campagne ac, unite u, campagne ca
                                     where a.id=ac.id_article and af.id_article_campagne=ac.id and u.id=a.id_unite and ca.id=ac.id_campagne and ac.id_fournisseur=af.id_fournisseur and c.id_article=a.id and c.id_campagne=ca.id and ac.id_fournisseur=$i_idFournisseur and ca.id=$i_idCampagne
                                     group by a.nom, a.poids_paquet_fournisseur) Prix_Total_TTC";
        return $sql_query;
    }

    /* Setters */

    public static function set($i_id, $i_idArticle, $i_idCampagne, $i_idUtilisateur, $i_quantite) {
        $sql_query = "update commande set id_article = '$i_idArticle', id_campagne = '$i_idCampagne',
                id_utilisateur='$i_idUtilisateur', quantite ='$i_quantite' where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdArticle($i_id, $i_idArticle) {
        $sql_query = "update commande set id_article='$i_idArticle' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdCampagne($i_id, $i_idCampagne) {
        $sql_query = "update commande set id_campagne='$i_idCampagne' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdUtilisateur($i_id, $i_idUtilisateur) {
        $sql_query = "update commande set id_utilisateur='$i_idUtilisateur' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setQuantite($i_id, $i_quantite) {
        $sql_query = "update commande set quantite='$i_quantite' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setAjoutQuantite($i_id, $i_quantite) {
        $sql_query = "update commande set quantite=quantite+'$i_quantite' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setEstLivre($i_id, $b_estLivre) {
        $sql_query = "update commande set est_livre='$b_estLivre' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from commande where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    /*
     * Gestion des transactions 
     */

    public static function beginTransaction(){
        $sql_query = "START TRANSACTION";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }
    
    public static function commit() {
        $sql_query = "COMMIT";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }
    
    public static function rollback() {
        $sql_query = "ROLLBACK";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }
    
    

}

?>
