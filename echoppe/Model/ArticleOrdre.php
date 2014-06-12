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
    
    public static function afficheObjectsPourDNDByCategorieByRayon($i_idCategorie, $i_idRayon) {
        $sql_query = "SELECT * FROM article_ordre ao, article a WHERE a.id_categorie = '$i_idCategorie' AND " . 
                                "ao.id_article = a.id AND " . 
                                "a.id_rayon = '$i_idRayon' " .
                                "ORDER BY ao.id";
        $sql_tmp = mysql_query($sql_query);
//        echo "<ul class='article'>\n";
//		while ($row = mysql_fetch_array($sql_tmp)) {
//			echo "<li>".$row['id_article']."<span></span>"."  ".$row['nom']."</li>\n";
//		}
//		echo "</ul>";
        echo "<ul class='article'>\n";
		while ($row = mysql_fetch_array($sql_tmp)) {
			//echo "<li>".$row['id_article']."<span></span>"."  ".$row['nom']."</li>\n";
                        echo "<li><span class='id'>".$row['id_article']."</span>"."  ".$row['nom']."</li>\n";
                }
		echo "</ul>";
        return;
    }
        
}
   

?>