<?php
class Rayon {

    /* Creaters */

    public static function create($s_nom) {
        $sql_query = "insert into rayon(nom) 
            values('$s_nom')";
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
        return $to_result;
    }


    public static function getObject($i_id) {
        $sql_query = "select * from rayon where id=$i_id";
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

    public static function getNom($i_id) {
        $sql_query = "select nom from rayon where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['nom']);
        }
        return $s_result;
    }

    /* Setters */

    public static function setNom($i_id, $s_nom) {
        $sql_query = "update rayon set nom='$s_nom'
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
