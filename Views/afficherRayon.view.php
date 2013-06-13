<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>
	if ($to_rayon != 0 and $to_rayon != array()) {
		?>
		<ul>
			<?php 
			foreach($to_rayon as $o_rayon) { 
				?>
					<li> <a href="<?php echo root ?>/commanderArticle.php/commanderArticle?idRayon=<?php echo $o_rayon['id']?>"><?php echo $o_rayon['nom'] ?></a></li>
					<?php
			}
	} else {
	?> Il n'y a aucun rayon
