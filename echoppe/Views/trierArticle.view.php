<!DOCTYPE html>
<html>
<body>
    
<h1>Trier les articles par drag'n'drop</h1>
<?php
if($to_descriptionArticle == array()){ 
?>
    <p><?php echo "Pas d'article pour ce rayon !"; ?></p>
<?php 
    return;
}
?>
<div id="columns">
<?php
        foreach ($to_descriptionArticle as $o_descriptionArticle) {?>
    <br><br><div class="column" draggable="true"> <?php echo $o_descriptionArticle['nom']; ?> </div>
<?php   }?>
</div>

<script src="../js/script.js"></script>
</body>
</html>
