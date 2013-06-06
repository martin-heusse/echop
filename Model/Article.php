<?Php
class Article {

    /* Creaters */

    public static function create($i_id, $i_id_rayon, $s_nom, $s_code, $i_poids_paquet_fournisseur,
				  $s_unite, $i_nb_paquet_colis, $s_description_courte, $s_description_longue) {
        $sql_query = "insert into Article(id,id_rayon,nom,code,poids_paquet_fournisseur,unite,nb_paquet,colis,description_courte,description_longue) 
            values('$i_id', '$i_id_rayon', '$s_nom','$s_code', '$i_poids_paquet_fournisseur',
		   '$s_unite', '$i_nb_paquet_colis', '$s_description_courte', '$s_description_longue')";
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

    public static function getObject($i_id) {
        $sql_query = "select * from article where id=$i_id";
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

    public static function getObjectsByIdRayon($i_id_rayon) {
        $sql_query = "select * from Article where id_rayon=$i_id_rayon";
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

    public static function getNom($i_id) {
        $sql_query = "select nom from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['nom']);
        }
        return $s_result;
    }

    public static function getIdCampagne($i_id) {
        $sql_query = "select id_campagne from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['login']);
        }
        return $s_result;
    }

    public static function getIdCampagne($i_id) {
        $sql_query = "select id_campagne from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['login']);
        }
        return $s_result;
    }

    public static function getIdCampagne($i_id) {
        $sql_query = "select id_campagne from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['login']);
        }
        return $s_result;
    }


    /* Setters */

    public static function set($i_id, $i_id_campagne, $i_id_rayon) {
      $sql_query = "update article set id_campagne = '$i_id_campagne',
      id_rayon='$i_id_rayon', where id=$i_id";
      $b_result =  mysql_query($sql_query);
      return $b_result;
    }

    public static function setIdCampagne($i_id, $i_id_campagne) {
        $sql_query = "update article set id_campagne='$i_id_campagne' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdRayon($i_id, $i_id_rayon) {
        $sql_query = "update article set id_rayon='$i_id_rayon' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }


    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from article where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
}
?>
