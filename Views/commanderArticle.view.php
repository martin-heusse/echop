<p>Bienvenue sur "L'Échoppe d'ici et d'ailleurs".</p>


    <ul>
<?php foreach($to_rayon as $o_rayon) {?>
        <li><a href="<?php echo root?>/commanderArticle&
    <?php $o_rayon[id]?>"><?php echo $o_rayon['nom']?></a></li>
<?php } ?>
    </ul>
