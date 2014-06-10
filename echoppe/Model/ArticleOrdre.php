<?Php
class ArticleOrdre {
    
    /*Creaters*/
    public static function create($i_idArticle, $i_idCategorie) {
        //$i_idCategorie = Article::getIdCategorie($i_idArticle);
        $sql_query = "insert into article_ordre(id_article, id_categorie)
            values('$i_idArticle','$i_idCategorie')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }
    
    public static function getObjectsByCategorie($i_idCategorie) {
        $sql_query = "select * from article_ordre where id_categorie='$i_idCategorie'";
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
        
}
   

?>