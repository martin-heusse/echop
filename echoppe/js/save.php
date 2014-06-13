    <?php
    
        require_once('../constants.php');
        require_once('../Model/Article.php');
        require_once('../Model/ArticleOrdre.php');

        
       // header('Content-type: text/html; charset=iso-8859-1'); 

	mysql_connect(db_host, db_username,db_pwd);
        mysql_select_db(db_name);
        
        $compteur = 1;
        if(count($_POST) > 0) {
           error_log("on a un count post positif ");
	   echo "Donnees reçues en POST:"; 
	   foreach($_POST as $k => $v){
                $id_categorie = Article::getIdCategorie($v);
                $offset = Article::getOffset($id_categorie);
                
                $new_id = $compteur + $offset;
                ArticleOrdre::updateArticleOrdre($new_id, $v);
               
               $compteur = $compteur +1;
           }
	} 
