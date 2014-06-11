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

        //require_once('../Model');
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
//        $result2 = mysql_query("SELECT * FROM article_ordre ao, article a WHERE a.id_categorie = '$recup_categorie' AND " . 
//                                "ao.id_article = a.id AND " . 
//                                "a.id_rayon = '$recup_rayon' " .
//                                "ORDER BY ao.id");

            //$result2 = 
            ArticleOrdre::afficheObjectsPourDNDByCategorieByRayon($recup_categorie, $recup_rayon);
//		echo "<ul class='article'>\n";
//		while ($row = mysql_fetch_array($result2)) {
//			echo "<li>".$row['id_article']."<span></span>"."  ".$row['nom']."</li>\n";
//                        //echo $row['nom'];
//		}
//		echo "</ul>";
?>


<script type="text/javascript">
    (function() {

	var items = document.querySelectorAll('.article li');
	var el = null;

	var ul = document.querySelector('ul');
	var form = document.querySelector('form');

	function addListeners() {
		[].forEach.call(items, function(item) {
			item.setAttribute('draggable', 'true');
			item.addEventListener('dragstart', dragStart, false);
			item.addEventListener('dragenter', dragEnter, false);
			item.addEventListener('dragover', dragOver, false);
			item.addEventListener('dragleave', dragLeave, false);
			item.addEventListener('drop', dragDrop, false);
			item.addEventListener('dragend', dragEnd, false);
		});
	}


	function dragStart(e) {
		this.style.opacity = '0.4';
		el = this;
		e.dataTransfer.effectAllowed = 'move';
		e.dataTransfer.setData('text/html', this.innerHTML);
	}

	function dragOver(e) {
		if (e.preventDefault) {
			e.preventDefault();
		}
		e.dataTransfer.dropEffect = 'move';
		return false;
	}

	function dragEnter(e) {
		this.classList.add('over');
	}

	function dragLeave(e) {
		this.classList.remove('over');
	}

	function dragDrop(e) {
		if (e.stopPropagation) {
			e.stopPropagation();
		}
		if (el != this) {
			el.innerHTML = this.innerHTML;
			this.innerHTML = e.dataTransfer.getData('text/html');
			listChange();
		}
		return false;
	}

	

	function dragEnd(e) {
		this.style.opacity = '1';
		[].forEach.call(items, function(item) {
			item.classList.remove('over');
		});
	}

	function listChange() {
                
		//var tempItems = document.querySelectorAll('.article li');
                var tempItems = document.querySelectorAll('.id');
		[].forEach.call(tempItems, function(item, i) {
			var order = i + 1;
                        var lecture = item.innerHTML;
                        var it2 = 'id_article=' + lecture; 
                        if (/<m(.+?)>/.test(it2)) {
                                it2 = it2.replace(/<m(.+?)>/,"");
                              }            
//                        var j = (it2.indexOf("<span></span>")); //balise non sémantique pour ne pas récupérer le nom de l'article
//                        
//                        it2 = it2.substring(0,j);
                        var it = it2 + '&id=' + order;
                        //alert(it);
			saveList(it);
		});
	}
	function saveList(item) {
		var request = new XMLHttpRequest();
                //alert(item);
		request.open('GET',"<?php echo root ?>/js/save.php?" +item,true);
		request.send();
	}

	

	addListeners();

})();

    
    

<!--src="../js/scripts.js">-->


</script>
</body>
</html>
