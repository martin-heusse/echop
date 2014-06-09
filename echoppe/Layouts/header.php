<?php
if (!isset($titre_page)) {
    $titre_page = "L'échoppe d'ici et d'ailleurs";
}
?><?php // <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title> <?php echo $titre_page ?> </title>
        <!-- Favicon -->
        <link href="<?php echo root ?>/Layouts/images/favicon.ico" rel="icon" type="image/x-icon"/>    
        <!-- Style -->
        <link rel="stylesheet" type="text/css" href="<?php echo root ?>/css/style.css" />
        <!-- JQuery -->
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        
       
    </head>
<body>
<div id="banniere">
    <img id="fond" src="<?php echo root ?>/Layouts/images/banner.png"/>
    
    <a href="<?php echo root ?>/index.php">
        <img id="logo" src="<?php echo root ?>/Layouts/images/logo_90x90.png" alt="<?php echo $titre_page ?>" /></a>
    <!--<p id="titre_banniere">L'Échoppe d'ici et d'ailleurs</p>-->
    <img height="50" width="500" id="titre" src="<?php echo root ?>/Layouts/images/titre.png" alt="<?php echo $titre_page ?>"/>
    
</div><!-- id="banniere" -->

<?php include($this->root().'/Layouts/menu.php') ?>

<div id="contenu">