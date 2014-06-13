<?Php
class ArticleOrdre {
    
    /*Creaters*/
    public static function create2($i_idArticle, $i_idCategorie) {
        //$i_idCategorie = Article::getIdCategorie($i_idArticle);
        $sql_query = "select count(*) number from article_ordre where id_categorie ='$i_idCategorie'";
        $sql_tmp = mysql_query($sql_query);
        $new_ordre = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $new_ordre = htmlentities($o_row['number'], null,'UTF-8');
        }
        $new_ordre = $new_ordre +1;
        
        
        $sql_query = "insert into article_ordre(id, id_article, id_categorie)
            values('$new_ordre','$i_idArticle','$i_idCategorie')";
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
    
    public static function updateArticleOrdre($i_idOrdre, $i_idArticle) {
        $sql_query = "REPLACE INTO article_ordre SET id = '$i_idOrdre', id_article = '$i_idArticle', id_categorie = 
                                    (SELECT a.id_categorie FROM article a WHERE a.id = '$i_idArticle');";
        mysql_query($sql_query);
        
        return;
        
    }
        
}
   

?>