<?php

require_once('def.php');
require_once('Model/Utilisateur.php');
require_once('Model/Article.php');
require_once('Util.php');

/*
 * Gère les exportations de données.
 */

class ExportController extends Controller {
    /*
     * Constructeur.
     */

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * Affiche la liste des exportations ou importations BD proposées
     */
    public function listeExport() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        if (!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }
        /* Récupère toutes les infos sur les bases de données*/
        $this->render('listeExport','' /*Mettre la liste des param requis à la view*/);
    }
    
public function exportUser() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        if (!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }
       
        // Connexion BD
        $database="BdEchoppe";
        mysql_connect(db_host, db_username,db_pwd);
        mysql_select_db(db_name);

        // la variable qui va contenir les données CSV
        $outputCsv = '';

        // Nom du fichier qu'on initialise puis qu'on attribue
        $fileName = "ExportUserBD.csv";
        
        // Deux requêtes : une qui exporte les données de la commande, l'autre le total TTC

        $requete = Utilisateur::getAllObjectsExportBD();
        $sql = mysql_query($requete);
                      
        if(mysql_num_rows($sql) > 0)
        {
            $i = 0;

            while($Row = mysql_fetch_assoc($sql))
            {
                $i++;

                // Si c'est la 1er boucle, on affiche le nom des champs pour avoir un titre pour chaque colonne
                if($i == 1)
                {
                    foreach($Row as $clef => $valeur)
                        $outputCsv .= trim($clef).';';

                    $outputCsv = rtrim($outputCsv, ';');
                    $outputCsv .= "\n";
                }

                // On parcours $Row et on ajout chaque valeur à cette ligne
                foreach($Row as $clef => $valeur)
                    $outputCsv .= trim($valeur).';';

                // Suppression du ; qui traine à la fin
                $outputCsv = rtrim($outputCsv, ';');

                // Saut de ligne
                $outputCsv .= "\n";

            }
        
        }
        else
            exit('Aucune donnée à enregistrer.');
                   
        header("Content-disposition: attachment; filename=".$fileName);
        header("Content-Type: application/force-download");
        header("Content-Transfer-Encoding: application/vnd.ms-excel\n");
        header("Pragma: no-cache");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
        header("Expires: 0");

        echo $outputCsv;
        exit();
    }    
    
    public function exportArticle() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        if (!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }
       
        // Connexion BD
        $database="BdEchoppe";
        mysql_connect(db_host, db_username,db_pwd);
        mysql_select_db(db_name);

        // la variable qui va contenir les données CSV
        $outputCsv = '';

        // Nom du fichier qu'on initialise puis qu'on attribue
        $fileName = "ExportArticleBD.csv";
        
        // Deux requêtes : une qui exporte les données de la commande, l'autre le total TTC

//        $requete = "Select * from article";
        $requete = Article::getAllObjectsExportBD();
        $sql = mysql_query($requete);
                      
        if(mysql_num_rows($sql) > 0)
        {
            $i = 0;

            while($Row = mysql_fetch_assoc($sql))
            {
                $i++;

                // Si c'est la 1er boucle, on affiche le nom des champs pour avoir un titre pour chaque colonne
                if($i == 1)
                {
                    foreach($Row as $clef => $valeur)
                        $outputCsv .= trim($clef).';';

                    $outputCsv = rtrim($outputCsv, ';');
                    $outputCsv .= "\n";
                }

                // On parcours $Row et on ajout chaque valeur à cette ligne
                foreach($Row as $clef => $valeur)
                    $outputCsv .= trim($valeur).';';

                // Suppression du ; qui traine à la fin
                $outputCsv = rtrim($outputCsv, ';');

                // Saut de ligne
                $outputCsv .= "\n";

            }
        
        }
        else
            exit('Aucune donnée à enregistrer.');
                   
        header("Content-disposition: attachment; filename=".$fileName);
        header("Content-Type: application/force-download");
        header("Content-Transfer-Encoding: application/vnd.ms-excel\n");
        header("Pragma: no-cache");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
        header("Expires: 0");

        echo $outputCsv;
        exit();
    }
         
    public function defaultAction() {
        header('Location: ' . root . '/utilisateur.php/listeUtilisateur');
        /*A changer*/
    }

}
new ExportController();
?>
