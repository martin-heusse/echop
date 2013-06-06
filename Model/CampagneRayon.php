<?php
class CommandeRayon {

    /* Creaters */

    public static function create($i_idCampagne,$i_idRayon) {
        $sql_query = "insert into campagne_rayon(id_campagne, id_rayon) 
            values('$i_idCampagne', '$i_idRayon')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from campagne_rayon";
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
        $sql_query = "select * from campagne_rayon where id_campagne=$i_idCampagne";
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

    public static function getObjectsByIdRayon($i_idRayon) {
        $sql_query = "select * from campagne_rayon where id_rayon=$i_idRayon";
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
        $sql_query = "select * from campagne_rayon where id=$i_id";
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

    public static function getIdCampagne($i_id) {
        $sql_query = "select id_campagne from campagne_rayon where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_campagne']);
        }
        return $i_result;
    }

    public static function getIdRayon($i_id) {
        $sql_query = "select id_rayon from campagne_rayon where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_rayon']);
        }
        return $i_result;
    }


    /* Setters */

    public static function set($i_id, $i_idCampagne, $i_idRayon) {
      $sql_query = "update campagne_rayon set id_campagne = '$i_idCampagne',
      id_rayon='$i_idRayon', where id=$i_id";
      $b_result =  mysql_query($sql_query);
      return $b_result;
    }

    public static function setIdCampagne($i_id, $i_idCampagne) {
        $sql_query = "update campagne_rayon set id_campagne='$i_idCampagne' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdRayon($i_id, $i_idRayon) {
        $sql_query = "update campagne_rayon set id_rayon='$i_idRayon' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }


    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from campagne_rayon where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
}
?>
