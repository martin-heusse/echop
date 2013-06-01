<?php
   // Connexion à la BD
   function connexion_bd() {
      $connect = mysql_connect('localhost', 'tranphi', 'toto');
      if (!$connect) {
         die("Erreur de connexion au serveur");
      }
      mysql_select_db('BdEchoppe') or
         die("Erreur de connexion à la base de données");
      define('connect', $connect);
      //return $connect;
   }
?>
