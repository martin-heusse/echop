<?php
require_once('def.php');
require_once('Model/Utilisateur.php');
if (!Utilisateur::isLogged()) {
    header('Location: connexion.php/connexion');
} else {
    header('Location: connexion.php/connexion');
}
?>
