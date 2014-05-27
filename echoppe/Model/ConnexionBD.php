<?php
// Connexion à la BD
function connexion_bd() {
    $connect = mysql_connect(db_host, db_username,db_pwd);
    if (!$connect) {
        die("Erreur de connexion au serveur");
    }
    mysql_select_db(db_name) //??
    or die("Erreur de connexion à la base de données");
    define('connect', $connect);
    mysql_set_charset("utf8");
    //return $connect;
}
?>
