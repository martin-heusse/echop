<?php
class Campagne {

    public static function getCampagneCourante() {
        $sql_query = "select * from campagne where actuel=1";
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

    public static function getIdCampagneCourante() {
        $sql_query = "select id from campagne where actuel=1";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $i_result = $o_row['id'];
        }
        return $i_result;
    }

    /* Creaters */

    public static function create($s_dateDebut, $b_etat, $b_courant) {
        $sql_query = "insert into campagne(date_debut, etat, courant) 
            values('$s_dateDebut', '$b_etat', '$b_courant')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from campagne";
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

    public static function getObjectsByDateDebut($s_dateDebut) {
        $sql_query = "select * from campagne where date_debut=$s_dateDebut";
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

    public static function getObjectsByEtat($b_etat) {
        $sql_query = "select * from campagne where etat=$b_etat";
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
        $sql_query = "select * from campagne where id=$i_id";
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

    public static function getDateDebut($i_id) {
        $sql_query = "select date_debut from campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['date_debut']);
        }
        return $s_result;
    }

    public static function getEtat($i_id) {
        $sql_query = "select etat from campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $b_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $b_result = htmlentities($o_row['etat']);
        }
        return $b_result;
    }

    public static function getActuel($i_id) {
        $sql_query = "select actuel from campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $b_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $b_result = htmlentities($o_row['etat']);
        }
        return $b_result;
    }

    /* Setters */

    public static function set($i_id, $s_dateDebut, $b_etat, $b_courant) {
        $sql_query = "update campagne set date_debut='$s_dateDebut', etat='$b_etat', courant='$b_courant'
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setDateDebut($i_id, $s_dateDebut) {
        $sql_query = "update campagne set date_debut='$s_dateDebut' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setEtat($i_id, $b_etat) {
        $sql_query = "update campagne set etat='$b_etat' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setActuel($i_id, $b_actuel) {
        $sql_query = "update campagne set actuel='$b_actuel' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from camapgne where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
}
?>
