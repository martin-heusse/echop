<?php
class Administrateur {

    public static function isAdministrateur($i_idUtilisateur) {
        $sql_query = "select id from administrateur where id_utilisateur='$i_idUtilisateur'";
        $sql_tmp = mysql_query($sql_query);
        $b_result = false;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            // $i_result = $o_row['id'];
            $b_result = true;
        }
        return $b_result;
    }
    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from administrateur";
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

    public static function getObjectsByIdUtilisateur($i_idUtilisateur) {
        $sql_query = "select * from administrateur where id_utilisateur=$i_idUtilisateur";
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

    public static function getIdUtilisateur($i_id) {
        $sql_query = "select id_utilisateur from administrateur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            $s_result = $o_row['id_utilisateur'];
        }
        return $s_result;
    }
}
?>
