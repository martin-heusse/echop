    <?php
    
        require_once('../constants.php');
        require_once('../Model/Article.php');

//        define('db_host','localhost'); // DB access config
//        define('db_username','root');
//        define('db_name','BdEchoppe');
//        define('db_pwd','12SCtKcI');
	mysql_connect(db_host, db_username,db_pwd);
        
        //if (!$con){die("erreur".mysql_error());}
        mysql_select_db(db_name);

	if (isset($_GET['id_article'])) {
		$id_article = $_GET['id_article'];
	}
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}
        
        echo $id_article;
        echo $id;
        
        
        $id_categorie = Article::getIdCategorie($id_article);
        $offset = Article::getOffset($id_categorie);

        
        echo $id;
        echo $offset;
        
       $new_id = $id + $offset;
        
       
        $sql_query = "REPLACE INTO article_ordre SET id = '$new_id', id_article = '$id_article', id_categorie = 
                            (SELECT a.id_categorie FROM article a WHERE a.id = '$id_article');";
	mysql_query($sql_query);

        echo "j'ai passe la requete";
