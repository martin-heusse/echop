<?php
if (!isset($titre_page)) {
    $titre_page = "Interface de gestion (oriental-import.com)";
}
?>
<?php // <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title> <?php echo $titre_page ?> </title>
        <!-- Style -->
        <link rel="stylesheet" type="text/css" href="<?php echo root ?>/css/style.css" />

        <!-- Fancybox -->
        <!-- Add jQuery library -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <!-- Add mousewheel plugin (this is optional) -->
        <script type="text/javascript" src="<?php echo root ?>/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
        <!-- Add fancyBox -->
        <link rel="stylesheet" href="<?php echo root ?>/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo root ?>/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>
        <!-- Optionally add helpers - button, thumbnail and/or media -->
        <link rel="stylesheet" href="<?php echo root ?>/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo root ?>/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
        <script type="text/javascript" src="<?php echo root ?>/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5"></script>
        <!-- Other -->
        <link rel="stylesheet" href="<?php echo root ?>/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo root ?>/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    </head>
<body>
<!-- Fancybox -->
<script type="text/javascript">
$( document ).ready(function() {
    $(".fancybox").fancybox();
});
</script>

<div id="banniere">
    <a href="<?php echo root ?>/index.php">
    <img id="logo" src="<?php echo root ?>/Layouts/images/banniere.png" alt="<?php echo $titre_page ?>"/></a>
</div><!-- id="banniere" -->

<?php include($this->root().'/Layouts/menu.php') ?>

<div id="contenu">

