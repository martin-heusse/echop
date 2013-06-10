<?php
class Commande {

    /* Getter clé primaire */

    public static function getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur) {
        $sql_query = "select id from commande where id_article=$i_idArticle and id_campagne=$i_idCampagne and id_utilisateur=$i_idUtilisateur";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id']);
        }
        return $i_result;
    }

    /* Creaters */

    public static function create($i_idArticle, $i_idCampagne,
        $i_idUtilisateur, $i_quantite) {
            $sql_query = "insert into commande(id_article, id_campagne, 
                id_utilisateur, quantite) 
                values('$i_idArticle', '$i_idCampagne', '$i_idUtilisateur', '$i_quantite')";
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
                $column = htmlentities($column);
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
                $column = htmlentities($column);
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
                $column = htmlentities($column);
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
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne) {
        $sql_query = "select distinct id_utilisateur from commande where id_article=$i_idArticle and id_campagne=$i_idCampagne";
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
        return $to_result;
    }

    public static function getIdArticleByIdCampagne($i_idCampagne) {
        $sql_query = "select distinct id_article from commande where id_campagne=$i_idCampagne";
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
        return $to_result;
    }

    public static function getIdArticleByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur) {
        $sql_query = "select distinct id_article from commande where id_campagne=$i_idCampagne and id_utilisateur=$i_idUtilisateur";
        $sql_tmp = mysql_query($sql_query);
        $ti_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $ti_result[] = $o_row;
        }
        return $ti_result;
    }

    public static function getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur) {
        $sql_query = "select * from commande where id_campagne=$i_idCampagne and id_utilisateur=$i_idUtilisateur";
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
        return $to_result;
    }

    public static function getObject($i_id) {
        $sql_query = "select * from commande where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getIdUtilisateurUniqueByIdCampagne($i_idCampagne) {
        $sql_query = "select distinct id_utilisateur from commande where id_campagne=$i_idCampagne";
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
        return $to_result;
    }

    public static function getIdArticle($i_id) {
        $sql_query = "select id_article from commande where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_article']);
        }
        return $i_result;
    }

    public static function getIdCampagne($i_id) {
        $sql_query = "select id_campagne from commande where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_campagne']);
        }
        return $i_result;
    }

    public static function getIdUtilisateur($i_id) {
        $sql_query = "select id_utilisateur from commande where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_utilisateur']);
        }
        return $i_result;
    }

    public static function getQuantite($i_id) {
        $sql_query = "select quantite from commande where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['quantite']);
        }
        return $i_result;
    }
    
    public static function getQuantiteByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur) {
        $sql_query = "select quantite from commande where id_article=$i_idArticle and id_campagne=$i_idCampagne and id_utilisateur=$i_idUtilisateur";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['quantite']);
        }
        return $i_result;
    }

    /* Setters */

    public static function set($i_id,$i_idArticle,
        $i_idCampagne, $i_idUtilisateur, $i_quantite) {
            $sql_query = "update commande set id_article = '$i_idArticle', id_campagne = '$i_idCampagne',
                id_utilisateur='$i_idUtilisateur', quantite ='$i_quantite' where id=$i_id";
            $b_result =  mysql_query($sql_query);
            return $b_result;
        }

    public static function setIdArticle($i_id, $i_idArticle) {
        $sql_query = "update commande set id_article='$i_idArticle' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdCampagne($i_id, $i_idCampagne) {
        $sql_query = "update commande set id_campagne='$i_idCampagne' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }


    public static function setIdUtilisateur($i_id, $i_idUtilisateur) {
        $sql_query = "update commande set id_utilisateur='$i_idUtilisateur' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }


    public static function setQuantite($i_id, $i_quantite) {
        $sql_query = "update commande set quantite='$i_quantite' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from commande where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
    
    public static function deleteByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur) {
        $sql_query = "delete from commande where id_article=$i_idArticle and id_campagne=$i_idCampagne and id_utilisateur=$i_idUtilisateur";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
        
    
}
?>
