<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
        <link rel="stylesheet" href="../css/style.css"/>
</head>
<body>

<?php
        $recup_categorie = $_GET['id_categ'];
        $recup_rayon = $_GET['id_ray'];        
        ?>

    <h1>Tri des articles <?php echo Categorie::getNom($recup_categorie)?>, <?php echo Rayon::getNom($recup_rayon)?></h1>

<div id="retour">
<!-- interface de parcours d'historique des campagnes pour utilisateur -->
<p><a class="action_navigation" href="<?php echo root ?>/article.php/choixCategorieTri?i_idRayon=<?php echo $recup_rayon; ?>">Retour au choix de la catégorie des articles à trier</a></p>
</div>

<h3>Pour trier, faites glisser les articles à l'endroit où vous voulez les placer</h3>
<?php
            /* Affichage de la liste des articles avec leur id (dans les bonnes classes)
             * pour qu'on puisse y faire un d'n'd
             */
            ArticleOrdre::afficheObjectsPourDNDByCategorieByRayon($recup_categorie, $recup_rayon);
?>

<script type="text/javascript">
    (function() {
	var items = document.querySelectorAll('.article li');
	var el = null;
        
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
        
        function isBelow(el1, el2) {
        var parent = el1.parentNode;
        if (el2.parentNode != parent) {
            return false;
        }

        var cur = el1.previousSibling;
        while (cur && cur.nodeType !== 9) {
            if (cur === el2) {
                return true;
            }
            cur = cur.previousSibling;
        }
        return false;
    }

        function moveElementNextTo(element, elementToMoveNextTo) {
        if (isBelow(element, elementToMoveNextTo)) {
            // Insert element before to elementToMoveNextTo.
            elementToMoveNextTo.parentNode.insertBefore(element, elementToMoveNextTo);
        }
        else {
            // Insert element after to elementToMoveNextTo.
            elementToMoveNextTo.parentNode.insertBefore(element, elementToMoveNextTo.nextSibling);
        }
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
                moveElementNextTo(el, this);
	}

	function dragLeave(e) {
		this.classList.remove('over');
	}

	function dragDrop(e) {
		if (e.stopPropagation) {
			e.stopPropagation();
		}
                listChange();
		if (el != this) {
			el.innerHTML = this.innerHTML;
			this.innerHTML = e.dataTransfer.getData('text/html');
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
                var tempItems = document.querySelectorAll('.id');
                var data = null;
		[].forEach.call(tempItems, function(item, i) {
			var order = i + 1;
                        /* On récupère le contenu des balises de classe id, qui contiennent...l'id */
                        var lecture = item.innerHTML; 
                        
                        /* Utilisation d'expressions regulieres pour supprimer les éventuelles balises <meta> qui apparaissent */
                        if (/<m(.+?)>/.test(lecture)) {
                                lecture = lecture.replace(/<m(.+?)>/,"");
                              }
                              
                        /* Stratégie : dans les keys du post qu'on est en train de créer, 
                         * plutôt que de stocker les informations id_article et l'ordre associé,
                         * on ne stocke qu'une seule info : id_articleN où N est l'ordre (order) 
                         * 
                         * c'est faisable car on parcourt les classes .id dans l'ordre naturel
                         * de lecture dans l'html, du coup le k-ème élément lu est d'ordre k.
                         * */      
                              
                        /* Si c'est le premier id qu'on écrit, pas besoin de '&' */
                        if (data == null) {
                            data = 'id_article'+ order +'=' + lecture;
                        }
                        /* Sinon on met un '&'*/
                        else {
                            data = data + '&id_article'+ order +'=' + lecture;
                        }
		}
                        );
                saveList(data);
	}
        
        /* On n'appelle saveList qu'une fois par drag'n'drop, 
         * en lui envoyant d'un bloc (POST) les infos pour faire n=nombre d'articles
         * requêtes SQL de mise à jour de la base.
         * 
         *  Ceci est plus optimisé que d'envoyer n requêtes XMLHttp ne contenant chacune que l'info (GET)
         *  sur un seul article et son ordre.
         * */
        function saveList(item) {
		var request = new XMLHttpRequest();
		request.open("POST","<?php echo root ?>/save.php",false);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		request.send(item);
	}
	addListeners();
})();

</script>
</body>
</html>
