<?php
class Rayon {

    /* Creaters */

    public static function create($s_nom, $f_marge) {
        $sql_query = "insert into rayon(nom, marge) 
            values('$s_nom', '$f_marge')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from rayon";
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
        foreach ($to_result as &$o_row) {
            $o_row['marge'] = number_format($o_row['marge'], 2, '.', ' ');
        }
        return $to_result;
    }

    public static function getObject($i_id) {
        $sql_query = "select * from rayon where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Formattage des nombres */
            $o_row['marge']    = number_format($o_row['marge']   , 2, '.', ' ');
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getObjectByNom($s_nom) {
        $sql_query = "select * from rayon where nom ='$s_nom'";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Formattage des nombres */
            $o_row['marge']    = number_format($o_row['marge']   , 2, '.', ' ');
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getNom($i_id) {
        $sql_query = "select nom from rayon where id='$i_id'";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['nom']);
        }
        return $s_result;
    } 

    public static function getMarge($i_id) {
        $sql_query = "select marge from rayon where id='$i_id'";
        $sql_tmp = mysql_query($sql_query);
        $f_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Formattage des nombres */
            $o_row['marge']    = number_format($o_row['marge']   , 2, '.', ' ');
            /* Sécurité et création du résultat */
            $f_result = htmlentities($o_row['marge']);
        }
        return $f_result;
    } 

    /* Setters */

    public static function set($i_id, $s_nom, $f_marge) {
        $sql_query = "update rayon set nom='$s_nom' and marge='$f_marge'
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setNom($i_id, $s_nom) {
        $sql_query = "update rayon set nom='$s_nom'
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setMarge($i_id, $f_marge) {
        $sql_query = "update rayon set marge='$f_marge'
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }


    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from rayon where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
}
?>
