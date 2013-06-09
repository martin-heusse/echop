<?php
class ArticleCampagne {

    /* Creaters */

    public static function create($i_idArticle, $i_idCampagne, $i_idFournisseur, $i_idTva, $f_poidsPaquetClient, $i_seuilMin, $f_prixHt, $f_prixTtc) {
        $sql_query = "insert into article_campagne(id_article, id_campagne, id_fournisseur, id_tva, poids_paquet_client, seuil_min, prix_ht, prix_ttc) 
            values('$i_idArticle', '$i_idCampagne', '$i_idFournisseur', '$i_idTva', '$f_poidsPaquetClient', '$i_seuilMin', '$f_prixHt', '$f_prixTtc')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from article_campagne";
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
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' ');            
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' ');            
        }
        return $to_result;
    }


    public static function getObjectsByIdArticle($i_idArticle) {
        $sql_query = "select * from article_campagne where id_article=$i_idArticle";
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
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' ');            
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' ');            
        }
        return $to_result;
    }


    public static function getObjectsByIdCampagne($i_idCampagne) {
        $sql_query = "select * from article_campagne where id_campagne=$i_idCampagne";
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
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' ');            
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' ');            
        }
        return $to_result;
    }

    public static function getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne) {
        $sql_query = "select * from article_campagne where id_campagne=$i_idCampagne and id_article=$i_idArticle";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
	    /* Formattage des nombres */
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' '); 
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' ');            
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getObjectsByIdFournisseur($i_idFournisseur) {
        $sql_query = "select * from article_campagne where id_fournisseur=$i_idFournisseur";
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
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' ');            
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' ');            
        }
        return $to_result;
    }
  

    public static function getObjectsByPoidsPaquetClient($f_poidsPaquetClient) {
        $sql_query = "select * from article_campagne where poids_paquet_client=$f_poidsPaquetClient";
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
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' ');      
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' ');                  
        }
        return $to_result;
    }


    public static function getObjectsByIdTva($i_idTva) {
        $sql_query = "select * from article_campagne where id_tva=$i_idTva";
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
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' ');          
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' ');              
        }
        return $to_result;
    }


    public static function getObjectsBySeuilMin($i_seuilMin) {
        $sql_query = "select * from article_campagne where seuil_min=$i_seuilMin";
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
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' ');          
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' ');              
        }
        return $to_result;
    }


    public static function getObjectsByPrixHt($f_prixHt) {
        $sql_query = "select * from article_campagne where prix_ht=$f_prixHt";
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
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' ');          
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' ');              
        }
        return $to_result;
    }


    public static function getObjectsByPrixTtc($f_prixTtc) {
        $sql_query = "select * from article_campagne where prix_ttc=$f_prixTtc";
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
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' ');        
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' ');                
        }
        return $to_result;
    }

    public static function getIdArticleByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur) {
        $sql_query = "select distinct id_article from article_campagne where id_campagne=$i_idCampagne and id_fournisseur=$i_idFournisseur";
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

    public static function getIdFournisseurByIdCampagne($i_idCampagne) {
        $sql_query = "select distinct id_fournisseur from article_campagne where id_campagne=$i_idCampagne and id_fournisseur is not null";
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
        $sql_query = "select * from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
	    /* Formattage des nombres */
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' '); 
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' ');            
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column);
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getIdArticle($i_id) {
        $sql_query = "select id_article from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_article']);
        }
        return $i_result;
    }


    public static function getIdCampagne($i_id) {
        $sql_query = "select id_campagne from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_campagne']);
        }
        return $i_result;
    }

    public static function getIdFournisseur($i_id) {
        $sql_query = "select id_fournisseur from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_fournisseur']);
        }
        return $i_result;
    }

    public static function getPoidsPaquetClient($i_id) {
        $sql_query = "select poids_paquet_client from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $f_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
	    /* Formattage des nombres */
            $o_row['poids_paquet_client']    = number_format($o_row['poids_paquet_client']   , 2, '.', ' ');
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' '); 
            /* Sécurité et création du résultat */
            $f_result = htmlentities($o_row['poids_paquet_client']);
        }
        return $f_result;
    }


    public static function getIdTva($i_id) {
        $sql_query = "select id_tva from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_tva']);
        }
        return $i_result;
    }

    public static function getSeuilMin($i_id) {
        $sql_query = "select seuil_min from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['seuil_min']);
        }
        return $i_result;
    }

    public static function getPrixHt($i_id) {
        $sql_query = "select seuil_max from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
	    /* Formattage des nombres */
            $o_row['prix_ht']    = number_format($o_row['prix_ht']   , 2, '.', ' '); 
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['prix_ht']);
        }
        return $i_result;
    }

    public static function getPrixTtc($i_id) {
        $sql_query = "select prix_ttc from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $f_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
	    /* Formattage des nombres */
            $o_row['prix_ttc']    = number_format($o_row['prix_ttc']   , 2, '.', ' '); 
            /* Sécurité et création du résultat */
            $f_result = htmlentities($o_row['prix_ttc']);
        }
        return $f_result;
    }


    /* Setters */

    public static function set($i_id, $i_idArticle, $i_idCampagne, $i_idFournisseur, $i_idTva, $f_poidsPaquetClient, $i_seuilMin, $f_prixHt, $f_prixTtc) {
        $sql_query = "update article_campagne set id_article='$i_idArticle', id_campagne='$i_idCampagne', id_fournisseur='$i_idFournisseur', id_tva='$i_idTva', poids_paquet_colis='$f_poidsPaquetColis', seuil_min='$i_seuilMin', prix_ht='$f_prixHt', prix_ttc='$f_prixTtc' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdArticle($i_id, $i_idArticle) {
        $sql_query = "update article_campagne set id_article='$i_idArticle' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdCampagne($i_id, $i_idCampagne) {
        $sql_query = "update article_campagne set id_campagne='$i_idCampagne' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdFournisseur($i_id, $i_idFournisseur) {
        $sql_query = "update article_campagne set id_fournisseur='$i_idFournisseur' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setPoidsPaquetClient($i_id, $f_poidsPaquetClient) {
        $sql_query = "update article_campagne set poids_paquet_client='$f_poidsPaquetClient' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setIdTva($i_id, $i_idTva) {
        $sql_query = "update article_campagne set id_tva='$i_idTva' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setSeuilMin($i_id, $i_seuilMin) {
        $sql_query = "update article_campagne set seuil_min='$i_seuilMin' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setPrixHt($i_id, $f_prixHt) {
        $sql_query = "update article_campagne set prix_ht='$f_prixHt' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setPrixTtc($i_id, $f_prixTtc) {
        $sql_query = "update article_campagne set prix_ttc='$f_prixTtc' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from article_campagne where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
}
?>
