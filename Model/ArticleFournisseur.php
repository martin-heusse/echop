
<?php
class ArticleFournisseur {

    /* Creaters */

    public static function create($i_idArticleCampagne, $i_idFournisseur, $f_prixHt, $f_prixTtc, $s_code, $b_prixTtcHt, $b_ventePaquetUnite) {
        $sql_query = "insert into article_fournisseur(id_article_campagne, id_fournisseur, prix_ht, prix_ttc, code, prix_ttc_ht, vente_paquet_unite)
            values('$i_idArticleCampagne', '$i_idFournisseur', '$f_prixHt', '$f_prixTtc', '$s_code', '$b_prixTtcHt', '$b_ventePaquetUnite')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from article_fournisseur";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        /* Formattage des nombres */
        foreach ($to_result as &$o_row) {
            $o_row['prix_ht']  = number_format($o_row['prix_ht'],  2, '.', ' ');
            $o_row['prix_ttc'] = number_format($o_row['prix_ttc'], 2, '.', ' ');
        }
        return $to_result;
    }

    public static function getObjectsByIdArticleCampagne($i_idArticleCampagne) {
        $sql_query = "select * from article_fournisseur where id_article_campagne=$i_idArticleCampagne";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        /* Formattage des nombres */
        foreach ($to_result as &$o_row) {
            $o_row['prix_ht']  = number_format((double)$o_row['prix_ht'], 2, '.', ' ');
            $o_row['prix_ttc'] = number_format((double)$o_row['prix_ttc'], 2, '.', ' ');

        }
        return $to_result;
    }

    public static function getObjectsByIdFournisseur($i_idFournisseur) {
        $sql_query = "select * from article_fournisseur where id_fournisseur=$i_idFournisseur";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        /* Formattage des nombres */
        foreach ($to_result as &$o_row) {
            $o_row['prix_ht']  = number_format($o_row['prix_ht'],  2, '.', ' ');
            $o_row['prix_ttc'] = number_format($o_row['prix_ttc'], 2, '.', ' ');
        }
        return $to_result;
    }


    public static function getObjectsByPrixHt($f_prixHt) {
        $sql_query = "select * from article_fournisseur where prix_ht=$f_prixHt";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        /* Formattage des nombres */
        foreach ($to_result as &$o_row) {
            $o_row['prix_ht']  = number_format($o_row['prix_ht'],  2, '.', ' ');
            $o_row['prix_ttc'] = number_format($o_row['prix_ttc'], 2, '.', ' ');
        }
        return $to_result;
    }

    public static function getObjectsByPrixTtc($f_prixHt) {
        $sql_query = "select * from article_fournisseur where prix_ttc=$f_prixTtc";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        /* Formattage des nombres */
        foreach ($to_result as &$o_row) {
            $o_row['prix_ht']  = number_format($o_row['prix_ht'],  2, '.', ' ');
            $o_row['prix_ttc'] = number_format($o_row['prix_ttc'], 2, '.', ' ');
        }
        return $to_result;
    }

    public static function getObjectByIdArticleCampagneIdFournisseur($i_idArticleCampagne,$i_idFournisseur) {
        $sql_query = "select * from article_fournisseur where id_article_campagne=$i_idArticleCampagne and id_fournisseur=$i_idFournisseur";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Formattage des nombres */
            $o_row['prix_ht']  = number_format($o_row['prix_ht'],  2, '.', ' ');
            $o_row['prix_ttc'] = number_format($o_row['prix_ttc'], 2, '.', ' ');
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getObject($i_id) {
        $sql_query = "select * from article_fournisseur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Formattage des nombres */
            $o_row['prix_ht']  = number_format($o_row['prix_ht'],  2, '.', ' ');
            $o_row['prix_ttc'] = number_format($o_row['prix_ttc'], 2, '.', ' ');
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getIdArticleCampagne($i_id) {
        $sql_query = "select id_article_campagne from article_fournisseur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_article_campagne']);
        }
        return $i_result;
    }

    public static function getIdFournisseur($i_id) {
        $sql_query = "select id_fournisseur from article_fournisseur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_fournisseur']);
        }
        return $i_result;
    }

    public static function getPrixTtc($i_id) {
        $sql_query = "select prix_ttc from article_fournisseur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Formattage des nombres */
            $o_row['prix_ttc'] = number_format($o_row['prix_ttc'], 2, '.', ' ');
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['prix_ttc']);
        }
        return $i_result;
    }

    public static function getPrixTtcByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur) {
        $sql_query = "select prix_ttc from article_fournisseur where id_article_campagne=$i_idArticleCampagne and id_fournisseur=$i_idFournisseur ";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Formattage des nombres */
            $o_row['prix_ttc'] = number_format($o_row['prix_ttc'], 2, '.', ' ');
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['prix_ttc']);
        }
        return $i_result;
    }

    public static function getPrixHt($i_id) {
        $sql_query = "select prix_ht from article_fournisseur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Formattage des nombres */
            $o_row['prix_ht'] = number_format($o_row['prix_ht'], 2, '.', ' ');
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['prix_ht']);
        }
        return $i_result;
    }

    public static function getCode($i_id) {
        $sql_query = "select code from article_fournisseur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['code']);
        }
        return $s_result;
    }

    public static function getPrixTtcHt($i_id) {
        $sql_query = "select pix_ttc_ht from article_fournisseur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $b_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $b_result = htmlentities($o_row['prix_ttc_ht']);
        }
        return $b_result;
    }

    public static function getVentePaquetUnite($i_id) {
        $sql_query = "select vente_paquet_unite from article_fournisseur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $b_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $b_result = htmlentities($o_row['vente_paquet_unite']);
        }
        return $b_result;
    }

    /* Setters */

    public static function set($i_id, $i_idArticleCampagne, $i_idFournisseur, $f_prixHt, $f_prixTtc, $b_prixTtcHt, $b_ventePaquetUnite) {
        $sql_query = "update article_fournisseur set id_article_campagne='$i_idArticleCampagne', id_fournisseur='$i_idFournisseur', prix_ht='$f_prixHt', prix_ttc='$f_prixTtc'
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdArticle($i_id, $i_idArticleCampagne) {
        $sql_query = "update article_fournisseur set id_article_campagne='$i_idArticleCampagne' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdFournisseur($i_id, $i_idFournisseur) {
        $sql_query = "update article_fournisseur set id_fournisseur='$i_idFournisseur'
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setPrixHt($i_id, $f_prixHt) {
        $sql_query = "update article_fournisseur set prix_ht='$f_prixHt'
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setPrixTtc($i_id, $f_prixTtc) {
        $sql_query = "update article_fournisseur set prix_ttc='$f_prixTtc'
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setCode($i_id, $s_code) {
        $sql_query = "update article_fournisseur set code='$s_code' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setPrixTtcHt($i_id, $b_prixTtcHt) {
        $sql_query = "update article_fournisseur set prix_ttc_ht='$b_prixTtcHt' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from article_fournisseur where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
}
?>

