<?Php
class ArticleOrdre {
    
    /*Creaters*/
    public static function create($i_idArticle) {
        $sql_query = "insert into article_ordre(id_article)
            values('$i_idArticle')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }
        
}
   

?>