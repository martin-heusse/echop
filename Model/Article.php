<?Php
class Article {

    /* Creaters */

    public static function create($i_idRayon, $s_nom, $f_poidsPaquetFournisseur,
          $i_idUnite, $i_nbPaquetColis, $s_descriptionCourte, $s_descriptionLongue) {
        $sql_query = "insert into article(id_rayon,nom,poids_paquet_fournisseur,id_unite,nb_paquet,colis,description_courte,description_longue) 
            values('$i_id', '$i_idRayon', '$s_nom', '$f_poidsPaquetFournisseur',
           '$i_IdUnite', '$i_nbPaquetColis', '$s_descriptionCourte', '$s_descriptionLongue')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from article";
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
            $o_row['poids_paquet_fournisseur']    = number_format($o_row['poids_paquet_fournisseur']   , 2, '.', ' ');
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
    /* Formattage des nombres */
            foreach ($to_result as &$o_row) {
            $o_row['poids_paquet_fournisseur']    = number_format($o_row['poids_paquet_fournisseur']   , 2, '.', ' ');
            
            }
        return $o_result;
    }

    public static function getObjectsByIdRayon($i_idRayon) {
      $sql_query = "select * from article where id_rayon=$i_idRayon";
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
    $o_row['poids_paquet_fournisseur']    = number_format($o_row['poids_paquet_fournisseur']   , 2, '.', ' ');     
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

    public static function getIdRayon($i_id) {
        $sql_query = "select id_rayon from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_rayon']);
        }
        return $i_result;
    }

    public static function getPoidsPaquetFournisseur($i_id) {
        $sql_query = "select poids_paquet_fournisseur from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $f_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
        /* Formattage des nombres */
            $o_row['poids_paquet_fournisseur']    = number_format($o_row['poids_paquet_fournisseur']   , 2, '.', ' ');
            /* Sécurité et création du résultat */
            $f_result = htmlentities($o_row['poids_paquet_fournisseur']);
        }
        return $f_result;
    }

    public static function getIdUnite($i_id) {
        $sql_query = "select id_unite from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_unite']);
        }
        return $i_result;
    }

    public static function getNbPaquetColis($i_id) {
        $sql_query = "select nb_paquet_colis from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['nb_paquet_colis']);
        }
        return $i_result;
    }

    public static function getDescriptionCourte($i_id) {
        $sql_query = "select description_courte from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['description_courte']);
        }
        return $s_result;
    }

    public static function getDescriptionLongue($i_id) {
        $sql_query = "select description_longue from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['description_longue']);
        }
        return $s_result;
    }


    /* Setters */

    public static function set($i_id, $i_idRayon, $s_nom, $f_poidsPaquetFournisseur,
                  $i_idUnite, $i_nbPaquetColis, $s_descriptionCourte, $s_descriptionLongue) {
      $sql_query = "update article set id_rayon = '$i_idRayon',
      nom ='$s_nom', poids_paquet_fournisseur = '$f_poidsPaquetFournisseur', id_unite = '$i_idUnite', nb_paquet_colis = '$i_nbPaquetColis', description_courte = '$s_descriptionCourte', description_longue = '$s_descriptionLongue' where id=$i_id";
      $b_result =  mysql_query($sql_query);
      return $b_result;
    }

    public static function setIdRayon($i_id, $i_idRayon) {
        $sql_query = "update article set id_rayon ='$i_idRayon' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdUnite($i_id, $i_idUnite) {
        $sql_query = "update article set id_unite ='$i_idUnite' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setNom($i_id, $s_nom) {
        $sql_query = "update article set nom ='$s_nom' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setPoidsPaquetFournisseur($i_id, $f_PoidsPaquetFournisseur) {
        $sql_query = "update article set poids_paquet_fournisseur ='$f_poidsPaquetFournisseur' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setNbPaquetColis($i_id, $i_nbPaquetColis) {
        $sql_query = "update article set nb_paquet_colis ='$i_nbPaquetColis' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setDescriptionCourte($i_id, $s_descriptionCourte) {
        $sql_query = "update article set description_courte ='$s_descriptionCourte' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setDescriptionLongue($i_id, $s_descriptionLongue) {
        $sql_query = "update article set description_longue ='$s_descriptionLongue' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }


    /* Deleters */

    public static function delete($i_id, $i_idRayon, $s_nom, $f_poidsPaquetFournisseur,
                  $i_idUnite, $i_nbPaquetColis, $s_descriptionCourte, $s_descriptionLongue) {
        $sql_query = "delete from article where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
}
?>
