<?php
class Tva {

    /* Creaters */

    public static function create($f_valeur) {
        $sql_query = "insert into tva(valeur) 
            values('$f_valeur')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from tva";
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
            $o_row['valeur'] = number_format($o_row['valeur'], 2, '.', ' ');
        }
        return $to_result;
    }

    public static function getObject($i_id) {
        $sql_query = "select * from tva where id=$i_id";
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
        /* Formattage des nombres */
        foreach ($to_result as &$o_row) {
            $o_row['valeur'] = number_format($o_row['valeur'], 2, '.', ' ');
        }
        return $o_result;
    }

    public static function getValeur($i_id) {
        $sql_query = "select valeur from tva where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['valeur']);
        }
        /* Formattage des nombres */
        foreach ($to_result as &$o_row) {
            $o_row['valeur'] = number_format($o_row['valeur'], 2, '.', ' ');
        }
        return $s_result;
    }

    /* Setters */

    public static function set($i_id, $f_valeur) {
        $sql_query = "update tva set valeur='$f_valeur' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setValeur($i_id, $f_valeur) {
        $sql_query = "update tva set valeur='$f_valeur' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from tva where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
}
?>
