<?php
class Unite {

    /* Creaters */

    public static function create($s_unite) {
        $sql_query = "insert into unite(valeur) 
            values('$s_unite')";
        mysql_query($sql_query);
        $s_result = mysql_insert_id();
        return $s_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from unite";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null,'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getObject($i_id) {
        $sql_query = "select * from unite where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null,'UTF-8');
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getValeur($i_id) {
        $sql_query = "select valeur from unite where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['valeur'], null,'UTF-8');
        }
        return $s_result;
    }

    public static function getUnite($i_id) {
        static $unites = null;

        if (!isset($unites[$i_id])){
            $sql_query = "select valeur from unite where id=$i_id";
            $sql_tmp = mysql_query($sql_query);
            $s_result = null;
            if ($o_row = mysql_fetch_assoc($sql_tmp)) {
                /* Sécurité et création du résultat */
                $s_result = htmlentities($o_row['valeur'], null,'UTF-8');
            }
            if ($s_result!=null){
                $unites[$i_id]=$s_result;
            }
        }
        else{
             $s_result=$unites[$i_id];
        }
        return $s_result;
    }

    /* Setters */

    public static function set($i_id, $s_unite) {
        $sql_query = "update unite set valeur='$s_unite' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setValeur($i_id, $s_unite) {
        $sql_query = "update unite set valeur='$s_unite' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from unite where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
}
?>
