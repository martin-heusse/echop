    <?php
    
        require_once('../constants.php');
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
       
        $sql_query = "REPLACE INTO article_ordre SET id = '$id', id_article = '$id_article'";
	mysql_query($sql_query);

        echo "j'ai passe la requete";
