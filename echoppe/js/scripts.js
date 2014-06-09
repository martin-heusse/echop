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
		var tempItems = document.querySelectorAll('.article li');
		[].forEach.call(tempItems, function(item, i) {
			var order = i + 1;
                        var lecture = item.innerHTML;
                        
                        var it2 = 'id_article=' + lecture; 
                        if (/<m(.+?)>/.test(it2)) {
                                it2 = it2.replace(/<m(.+?)>/,"");
                              }
                              
                        var j = (it2.indexOf("<span></span>")); //balise non sémantique pour ne pas récupérer le nom de l'article
                        
                        it2 = it2.substring(0,j);
                        
                        var it = it2 + '&id=' + order;
			saveList(it);
		});
	}
	function saveList(item) {
		var request = new XMLHttpRequest();
                //alert(item);
		request.open('GET', 'http://localhost/~Nabil/echoppe/echoppe/js/save.php?'+item,true);
		request.send();
	}

	

	addListeners();

})();
