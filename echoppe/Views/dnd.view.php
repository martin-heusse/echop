<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
        <link rel="stylesheet" href="../css/style.css"/>

	<title>Drag & Drop</title>
</head>
<body>

<h1>So drag & drop</h1>

<?php

        $recup_categorie = $_GET['id_categ'];
        $recup_rayon = $_GET['id_ray'];
        //$offset = Article::getOffset(3);
        
        ?>
<div id="retour">
<!-- interface de parcours d'historique des campagnes pour utilisateur -->
<p><a class="action_navigation" href="<?php echo root ?>/article.php/choixCategorieTri?i_idRayon=<?php echo $recup_rayon; ?>">Retour au choix de la catégorie des articles à trier</a></p>
</div>
<?php
        
        //echo $offset;
        $result = mysql_query("SELECT * FROM article_ordre ao, article a WHERE a.id_categorie = '$recup_categorie' AND " . 
                                "ao.id_article = a.id AND " . 
                                "a.id_rayon = '$recup_rayon' " .
                                "ORDER BY ao.id");
		echo "<ul class='article'>\n";
		while ($row = mysql_fetch_array($result)) {
			echo "<li>".$row['id_article']."<span></span>"."  ".$row['nom']."</li>\n";
                        //echo $row['nom'];
		}
		echo "</ul>";
?>
<!--	<ul class="article">
		<li>This is item #1</li>
		<li>This is item #2</li>
		<li>This is item #3</li>
		<li>This is item #4</li>
	</ul>-->

<script src="../js/scripts.js"></script>
</body>
</html>
