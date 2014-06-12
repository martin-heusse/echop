<?php
class Categorie {

    /* Creaters */

    public static function create($s_nom) {
        $sql_query = "insert into categorie(nom) 
            values('$s_nom')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from categorie";
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
    
    public static function getAllObjectsOrderByName() {
        $sql_query = "select * from categorie order by nom";
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
        $sql_query = "select * from categorie where id=$i_id";
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

    public static function getObjectByNom($s_nom) {
        $sql_query = "select * from categorie where nom ='$s_nom'";
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

    public static function getNom($i_id) {
        static $noms = null;

        if (!isset($noms[$i_id])){
            $sql_query = "select nom from categorie where id='$i_id'";
            $sql_tmp = mysql_query($sql_query);
            $s_result = null;
            if ($o_row = mysql_fetch_assoc($sql_tmp)) {
                /* Sécurité et création du résultat */
                $s_result = htmlentities($o_row['nom'], null,'UTF-8');
            }
            if ($s_result!=null){
                $noms[$i_id]=$s_result;
            }

        }
        else{
            $s_result=$noms[$i_id];
        }
        return $s_result;
    } 

    /* Setters */

    public static function set($i_id, $s_nom) {
        $sql_query = "update categorie set nom='$s_nom' and marge='$f_marge'
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setNom($i_id, $s_nom) {
        $sql_query = "update categorie set nom='$s_nom'
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from categorie where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
}
?>
