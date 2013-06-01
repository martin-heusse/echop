<?php
class PhotoArticle {

    /* Creaters */

    public static function create($s_nomImage, $i_idArticle) {
        $sql_query = "insert into PhotoArticle(nomImage, idArticle) values('$s_nomImage', '$i_idArticle')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from PhotoArticle";
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
        $sql_query = "select * from PhotoArticle where idArticle=$i_idArticle";
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
        $sql_query = "select * from PhotoArticle where id=$i_id";
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

    public static function getNomImage($i_id) {
        $sql_query = "select nomImage from PhotoArticle where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['nomImage']);
        }
        return $s_result;
    }

    /* Setters */

    public static function set($i_id, $s_nomImage, $i_idArticle) {
        $sql_query = "update PhotoArticle set nomImage='$s_nomImage', idArticle=$i_idArticle where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setNomImage($i_id, $s_nomImage) {
        $sql_query = "update PhotoArticle set nomImage='$s_nomImage' where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from PhotoArticle where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function deleteByNomImage($s_nomImage) {
        $sql_query = "delete from PhotoArticle where nomImage='$s_nomImage'";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function deleteByIdArticle($i_idArticle) {
        $sql_query = "delete from PhotoArticle where idArticle=$i_idArticle";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }
}
?>
