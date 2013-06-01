<?php
class Article {

    /* Creaters */

    public static function create($s_reference, $s_nom, $f_hauteur, $f_largeur, $f_poids, $f_prixGros, $f_prixDetail, $i_qteR, $i_qteV, $i_idCategorie) {
        $sql_query = "insert into Article(reference, nom, hauteur, largeur, poids, prixGros, prixDetail, qteR, qteV, idCategorie) 
            values('$s_reference', '$s_nom', '$f_hauteur', '$f_largeur', '$f_poids', '$f_prixGros', '$f_prixDetail', '$i_qteR', '$i_qteV', '$i_idCategorie')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from Article";
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

    public static function getObjectsByIdCategorie($i_id) {
        $sql_query = "select * from Article where idCategorie=$i_id";
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
            $o_row['hauteur']    = number_format($o_row['hauteur']   , 2, '.', ' ');
            $o_row['largeur']    = number_format($o_row['largeur']   , 2, '.', ' ');
            $o_row['poids']      = number_format($o_row['poids']     , 3, '.', ' ');
            $o_row['prixGros']   = number_format($o_row['prixGros']  , 2, '.', ' ');
            $o_row['prixDetail'] = number_format($o_row['prixDetail'], 2, '.', ' ');
            $o_row['qteR']       = number_format($o_row['qteR']      , 0, '.', ' ');
            $o_row['qteV']       = number_format($o_row['qteV']      , 0, '.', ' ');
        }
        return $to_result;
    }

    public static function getObject($i_id) {
        $sql_query = "select * from Article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Formattage des nombres */
            $o_row['hauteur']    = number_format($o_row['hauteur']   , 2, '.', ' ');
            $o_row['largeur']    = number_format($o_row['largeur']   , 2, '.', ' ');
            $o_row['poids']      = number_format($o_row['poids']     , 3, '.', ' ');
            $o_row['prixGros']   = number_format($o_row['prixGros']  , 2, '.', ' ');
            $o_row['prixDetail'] = number_format($o_row['prixDetail'], 2, '.', ' ');
            $o_row['qteR']       = number_format($o_row['qteR']      , 0, '.', ' ');
            $o_row['qteV']       = number_format($o_row['qteV']      , 0, '.', ' ');
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    /* Setters */

    public static function set($i_id, $s_reference, $s_nom, $f_hauteur, $f_largeur, $f_poids, $f_prixGros, $f_prixDetail, $i_qteR, $i_qteV, $i_idCategorie) {
        $sql_query = "update Article set reference='$s_reference', nom='$s_nom', hauteur='$f_hauteur', largeur='$f_largeur', 
            poids='$f_poids', prixGros='$f_prixGros', prixDetail='$f_prixDetail', qteR='$i_qteR', qteV='$i_qteV', idCategorie='$i_idCategorie' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $i_result;
    }

    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from Article where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $i_result;
    }
}
?>
