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
        $result = mysql_query("SELECT * FROM article_ordre ao, article a WHERE ao.id_article = a.id ORDER BY ao.id");
		echo "<ul class='article'>\n";
		while ($row = mysql_fetch_array($result)) {
			echo "<li>".$row['id_article']."</li>\n";
                        echo $row['nom'];
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
