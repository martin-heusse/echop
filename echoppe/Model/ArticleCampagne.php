<?php
class ArticleCampagne {

    /* Getter clé primaire */
    public static function getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne) {
        $sql_query = "select id from article_campagne where id_article=$i_idArticle and id_campagne=$i_idCampagne";
        $sql_tmp = mysql_query($sql_query);
        $o_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            /*foreach ($o_row as &$column) {
                $column = htmlentities($column, null,'UTF-8');
            }*/
            /* Création du résultat */
            $o_result = htmlentities($o_row['id'], null,'UTF-8');
        }
        return $o_result;
    }

    public static function getIdByIdCampagne($i_idCampagne) {
        $sql_query = "select distinct id from article_campagne where id_campagne=$i_idCampagne";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        if($sql_tmp==null) return $to_result;
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null,'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = htmlentities($o_row['id'], null,'UTF-8');
        }
        return $to_result;
    }

    /* Creaters */

    public static function create($i_idArticle, $i_idCampagne, $i_idFournisseur, $i_idTva, $f_poidsPaquetClient, $i_seuilMin, $f_prixTtc, $b_enVente) {
        $sql_query = "insert into article_campagne(id_article, id_campagne, id_fournisseur, id_tva, poids_paquet_client, seuil_min, prix_ttc, en_vente) 
            values('$i_idArticle', '$i_idCampagne', '$i_idFournisseur', '$i_idTva', '$f_poidsPaquetClient', '$i_seuilMin', '$f_prixTtc', '$b_enVente')";
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
                $column = htmlentities($column, null,'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
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
                $column = htmlentities($column, null,'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getObjectsByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur) {
        //$sql_query = "select ac.*, sum() from article_campagne ac where id_campagne=$i_idCampagne and id_fournisseur=$i_idFournisseur";
        $sql_query = "select  f.nom as nom_fournisseur, af.code , af.vente_paquet_unite, af.prix_ttc_ht, af.prix_ttc ,ac.id_article ,ac.poids_paquet_client, sum(quantite)  as quantite_totale_unites , sum(quantite) * ac.poids_paquet_client as quantite_totale , sum(quantite)*af.prix_ttc as montant_total, article.nom, unite.valeur as unite, af.prix_ttc/poids_paquet_client as prix_unitaire from fournisseur f, article_fournisseur af, commande c, article_campagne ac , article , unite where ac.id_campagne=$i_idCampagne and ac.id_fournisseur=$i_idFournisseur and c.id_campagne=ac.id_campagne and c.id_article=ac.id_article and article.id=c.id_article and article.id_unite=unite.id and af.id_article_campagne = ac.id and af.id_fournisseur=ac.id_fournisseur and f.id=ac.id_fournisseur group by c.id_article ";
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

    public static function getNbArticlesByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur) {
        $sql_query = "select count(*) from article_campagne where id_campagne=$i_idCampagne and id_fournisseur=$i_idFournisseur";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        $to_result=mysql_fetch_assoc($sql_tmp);
        foreach ($to_result as $name=>$nb)
          return $nb;
    }
    
        public static function getObjectsCommandByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur) {
        $sql_query = "Select distinct ac.id, ac.id_article, ac.id_fournisseur, ac.id_tva, ac.poids_paquet_client, ac.seuil_min, ac.prix_ttc, ac.en_vente
from article_campagne ac, commande c
where ac.id_article=c.id_article and ac.id_campagne=c.id_campagne and c.id_campagne=$i_idCampagne and ac.id_fournisseur=$i_idFournisseur";
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
    
    

    public static function getObjectsByIdCampagne($i_idCampagne) {
        $sql_query = "select ac.* , a.id_rayon from article_campagne ac, article a  where ac.id_campagne=$i_idCampagne and ac.id_article=a.id ";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        if($sql_tmp==null) return $to_result;
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

    public static function getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne) {
        $sql_query = "select * from article_campagne where id_campagne=$i_idCampagne and id_article=$i_idArticle";
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

    public static function getObjectsByIdFournisseur($i_idFournisseur) {
        $sql_query = "select * from article_campagne where id_fournisseur=$i_idFournisseur";
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
  

    public static function getObjectsByPoidsPaquetClient($f_poidsPaquetClient) {
        $sql_query = "select * from article_campagne where poids_paquet_client=$f_poidsPaquetClient";
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


    public static function getObjectsByIdTva($i_idTva) {
        $sql_query = "select * from article_campagne where id_tva=$i_idTva";
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


    public static function getObjectsBySeuilMin($i_seuilMin) {
        $sql_query = "select * from article_campagne where seuil_min=$i_seuilMin";
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

    public static function getObjectsByPrixTtc($f_prixTtc) {
        $sql_query = "select * from article_campagne where prix_ttc=$f_prixTtc";
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

    public static function getIdArticleByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur) {
        $sql_query = "select distinct id_article from article_campagne where id_campagne=$i_idCampagne and id_fournisseur=$i_idFournisseur";
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

    public static function getIdArticleByIdCampagne($i_idCampagne) {
        $sql_query = "select distinct id_article from article_campagne where id_campagne=$i_idCampagne";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null,'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row['id_article'];
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
                $column = htmlentities($column, null,'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getPoidsPaquetFournisseurByIdArticle($i_idArticle) {
        $sql_query = "select poids_paquet_fournisseur from article_campagne where id_article=$i_idArticle";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_fournisseur'], null,'UTF-8');
        }
        return $i_result;
    }

    public static function getObject($i_id) {
        $sql_query = "select * from article_campagne where id=$i_id";
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

    public static function getIdArticle($i_id) {
        $sql_query = "select id_article from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_article'], null,'UTF-8');
        }
        return $i_result;
    }

    public static function getEnVente($i_id) {
        $sql_query = "select id_article from en_vente where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $b_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $b_result = htmlentities($o_row['en_vente'], null,'UTF-8');
        }
        return $b_result;
    }

    public static function getIdCampagne($i_id) {
        $sql_query = "select id_campagne from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_campagne'], null,'UTF-8');
        }
        return $i_result;
    }


    public static function getIdFournisseur($i_id) {
        $sql_query = "select id_fournisseur from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_fournisseur'], null,'UTF-8');
        }
        return $i_result;
    }
    public static function getPoidsPaquetClient($i_id) {
        $sql_query = "select poids_paquet_client from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $f_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $f_result = htmlentities($o_row['poids_paquet_client'], null,'UTF-8');
        }
        return $f_result;
    }


    public static function getIdTva($i_id) {
        $sql_query = "select id_tva from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['id_tva'], null,'UTF-8');
        }
        return $i_result;
    }

    public static function getSeuilMin($i_id) {
        $sql_query = "select seuil_min from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['seuil_min'], null,'UTF-8');
        }
        return $i_result;
    }

    public static function getSeuilMinByIdArticleIdCampagne($i_idArticle, $i_idCampagne) {
        $sql_query = "select seuil_min from article_campagne where id_article=$i_idArticle and id_campagne=$i_idCampagne";
        $sql_tmp = mysql_query($sql_query);
        $i_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['seuil_min'], null,'UTF-8');
        }
        return $i_result;
    }

    public static function getPrixTtc($i_id) {
        $sql_query = "select prix_ttc from article_campagne where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $f_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $f_result = htmlentities($o_row['prix_ttc'], null,'UTF-8');
        }
        return $f_result;
    }

    /* Setters */

    public static function set($i_id, $i_idArticle, $i_idCampagne, $i_idFournisseur, $i_idTva, $f_poidsPaquetClient, $i_seuilMin, $f_prixTtc, $b_enVente) {
        $sql_query = "update article_campagne set id_article='$i_idArticle', id_campagne='$i_idCampagne', id_fournisseur='$i_idFournisseur', id_tva='$i_idTva', poids_paquet_colis='$f_poidsPaquetColis', seuil_min='$i_seuilMin', prix_ttc='$f_prixTtc', en_vente='$b_enVente' 
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

    public static function setEnVente($i_id, $b_enVente) {
        $sql_query = "update article_campagne set en_vente='$b_enVente' 
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
