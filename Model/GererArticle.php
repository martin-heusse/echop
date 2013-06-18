<?php

class GererArticle {

    public static function descriptionArticle($i_idCampagne,$i_idRayon) {
        $sql_query = "SELECT DISTINCT ac.id AS id_article_campagne, " .
            "ac.en_vente, " .
            "a.nom, " .
            "a.description_courte, " .
            "a.description_longue, " .
            "a.nb_paquet_colis, " .
            "a.id_categorie, " .
            "a.id_unite AS id_unite_choisi, " .
            "u.valeur AS valeur_unite_choisi, " .
            "a.poids_paquet_fournisseur, " .
            "ac.poids_paquet_client, " .
            "ac.seuil_min, " .
            "ac.id_fournisseur AS id_fournisseur_choisi, " .
            "ac.id_tva AS id_tva_choisi, " .
            "ac.prix_ttc AS prix_echoppe, " .
            // arrondir le prix au kilo toujours au centime supérieur même en quand d'égalité
            "TRUNCATE(ac.prix_ttc/a.poids_paquet_fournisseur,2)+0.01 AS prix_echoppe_unite " .
            "FROM article a, " .
            "article_fournisseur af, " .
            "article_campagne ac, " .
            "unite u " .
            "WHERE a.id = ac.id_article AND " .
            "ac.id = af.id_article_campagne AND " .
            "a.id_unite = u.id AND " .
            "ac.id_campagne=$i_idCampagne AND " .
            "a.id_rayon=$i_idRayon " .
            "ORDER BY ac.id ";
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

    public static function fournisseurArticle($i_idCampagne,$i_idRayon) {
        $sql_query = "SELECT DISTINCT f.id AS id_fournisseur, " .
            "f.nom AS nom_fournisseur " .
            "FROM article a, " .
            "article_fournisseur af, " .
            "article_campagne ac, " .
            "fournisseur f " .
            "WHERE a.id = ac.id_article AND " .
            "ac.id = af.id_article_campagne AND " .
            "af.id_fournisseur = f.id AND " .
            "ac.id_campagne=$i_idCampagne AND " .
            "a.id_rayon=$i_idRayon ";
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

    public static function setEnVenteByIdCampagneIdRayon($b_enVente, $i_idCampagne, $i_idRayon) {
        $sql_query = " update article, article_campagne " .
                     " set article_campagne.en_vente = $b_enVente " .
                     " where article_campagne.id_campagne = $i_idCampagne " .
                     " and article.id_rayon = $i_idRayon ".
                     " and article_campagne.id_article = article.id";
        $b_result =  mysql_query($sql_query);
        return $b_result;

    } 
}
?>
