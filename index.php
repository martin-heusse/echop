<?php
require_once('def.php');
require_once('Model/Admin.php');
if (!Admin::isLogged()) {
    header('Location: connexion.php/connexion');
} else {
    header('Location: article.php');
}
?>
