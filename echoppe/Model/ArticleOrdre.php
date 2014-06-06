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
    
    public static function getOrdreArticle(){
        $result = mysql_query("SELECT * FROM article_ordre ORDER BY id");
		echo "<ul class='article'>\n";
		while ($row = mysql_fetch_array($result)) {
			echo "<li>".$row['id_article']."</li>\n";
		}
		echo "</ul>";
	}
        
}
   

?>