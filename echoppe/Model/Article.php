<?Php

class Article {
    /* Creaters */

    public static function create($i_idRayon, $i_idCategorie, $s_nom, $f_poidsPaquetFournisseur, $i_idUnite, $i_nbPaquetColis, $s_descriptionCourte, $s_descriptionLongue) {
        $sql_query = "insert into article(id_rayon,id_categorie,nom,poids_paquet_fournisseur,id_unite,nb_paquet_colis,description_courte,description_longue) 
            values('$i_idRayon','$i_idCategorie', '$s_nom', '$f_poidsPaquetFournisseur',
           '$i_idUnite', '$i_nbPaquetColis', '$s_descriptionCourte', '$s_descriptionLongue')";
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
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getAllObjectsExportBD() {
        $sql_query = "select * from article";
        return $sql_query;
    }

    public static function getObject($i_id) {
        $sql_query = "select * from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getMaxId() {
        $sql_query = "select max(id) from article";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['max(id)'], null, 'UTF-8');
        }
        return $s_result;
    }

    public static function getObjectsByIdRayon($i_idRayon) {
        $sql_query = "select * from article where id_rayon=$i_idRayon";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getObjectsByIdCategorie($i_idCategorie) {
        $sql_query = "select * from article where id_rayon='$i_idCategorie'";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null, 'UTF-8');
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
            $s_result = htmlentities($o_row['nom'], null, 'UTF-8');
        }
        return $s_result;
    }

    public static function getIdRayon($i_id) {
        $sql_query = "select id_rayon from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_rayon'], null, 'UTF-8');
        }
        return $i_result;
    }

    public static function getIdCategorie($i_id) {
        $sql_query = "select id_categorie from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_categorie'], null, 'UTF-8');
        }
        return $i_result;
    }

    public static function getPoidsPaquetFournisseur($i_id) {
        $sql_query = "select poids_paquet_fournisseur from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $f_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            $f_result = htmlentities($o_row['poids_paquet_fournisseur'], null, 'UTF-8');
        }
        return $f_result;
    }

    public static function getIdUnite($i_id) {
        $sql_query = "select id_unite from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_unite'], null, 'UTF-8');
        }
        return $i_result;
    }

    public static function getNbPaquetColis($i_id) {
        $sql_query = "select nb_paquet_colis from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['nb_paquet_colis'], null, 'UTF-8');
        }
        return $i_result;
    }

    public static function getDescriptionCourte($i_id) {
        $sql_query = "select description_courte from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['description_courte'], null, 'UTF-8');
        }
        return $s_result;
    }

    public static function getDescriptionLongue($i_id) {
        $sql_query = "select description_longue from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['description_longue'], null, 'UTF-8');
        }
        return $s_result;
    }

    public static function getNomNbPaquetColisDescriptionCourteDescriptionLongue($i_id) {
        $sql_query = "select nom,nb_paquet_colis,description_courte,description_longue from article where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result['nom'] = htmlentities($o_row['nom'], null, 'UTF-8');
            $s_result['nb_paquet_colis'] = htmlentities($o_row['nb_paquet_colis'], null, 'UTF-8');
            $s_result['description_courte'] = htmlentities($o_row['description_courte'], null, 'UTF-8');
            $s_result['description_longue'] = htmlentities($o_row['description_longue'], null, 'UTF-8');
        }
//         print_r ($s_result);
        return $s_result;
    }

    /* Setters */

    public static function set($i_id, $i_idCategorie, $i_idRayon, $s_nom, $f_poidsPaquetFournisseur, $i_idUnite, $i_nbPaquetColis, $s_descriptionCourte, $s_descriptionLongue) {
        $sql_query = "update article set id_rayon = '$i_idRayon', id_categorie = '$i_idCategorie',
      nom ='$s_nom', poids_paquet_fournisseur = '$f_poidsPaquetFournisseur', id_unite = '$i_idUnite', nb_paquet_colis = '$i_nbPaquetColis', description_courte = '$s_descriptionCourte', description_longue = '$s_descriptionLongue' where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdRayon($i_id, $i_idRayon) {
        $sql_query = "update article set id_rayon ='$i_idRayon' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdCategorie($i_id, $i_idCategorie) {
        $sql_query = "update article set id_categorie ='$i_idCategorie' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdUnite($i_id, $i_idUnite) {
        $sql_query = "update article set id_unite ='$i_idUnite' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setNom($i_id, $s_nom) {
        $sql_query = "update article set nom ='$s_nom' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setPoidsPaquetFournisseur($i_id, $f_poidsPaquetFournisseur) {
        $sql_query = "update article set poids_paquet_fournisseur ='$f_poidsPaquetFournisseur' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setNbPaquetColis($i_id, $i_nbPaquetColis) {
        $sql_query = "update article set nb_paquet_colis ='$i_nbPaquetColis' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setDescriptionCourte($i_id, $s_descriptionCourte) {
        $sql_query = "update article set description_courte ='$s_descriptionCourte' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    public static function setDescriptionLongue($i_id, $s_descriptionLongue) {
        $sql_query = "update article set description_longue ='$s_descriptionLongue' 
            where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

    /* Deleters */

//    public static function delete($i_id, $i_idRayon, $i_idCategorie, $s_nom, $f_poidsPaquetFournisseur,
//                  $i_idUnite, $i_nbPaquetColis, $s_descriptionCourte, $s_descriptionLongue) {
//        $sql_query = "delete from article where id=$i_id";
//        $b_result =  mysql_query($sql_query);
//        return $b_result;
//    }

    public static function delete($i_id) {
        $sql_query = "delete from article where id=$i_id";
        $b_result = mysql_query($sql_query);
        return $b_result;
    }

}

?>
