<?php

require_once('def.php');
require_once('Model/Export.php');
require_once('Model/Utilisateur.php');
require_once('Model/Administrateur.php');
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
    
    
    public function exportBD() {
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
        
        $database="BdEchoppe";
        
        // Connexion BD
        Export::connect();

        // la variable qui va contenir les données CSV
        $outputCsv = '';

        // Nom du fichier qu'on initialise puis qu'on attribue
        $fileName = "Export".$database."_".date('d/m/Y').".csv";

        // On récupère la liste des tables de la BD $database
        $result = Export::listeTables($database);
        
        // On récupère le nombre de résultat obtenu
        $num_rows = Export::numResultat($result);
        
        // Pour chaque table, on exporte les données
        for ($j = 0; $j < $num_rows; $j++) {
            $table=Export::nomTable($result, $j);
            $requete=Export::getAll($table);
            
            // Et on écrit dans l'excel en mettant les titres aux tables
            $outputCsv=Export::exportExcelTitresTables($requete, $outputCsv, $table);
          
        //Formatage du fichier
        Util::headerExcel($fileName);        
        
        }
        
        echo $outputCsv;
        exit();
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
        
        // Nom BD
        $database="BdEchoppe";
        
        // Connexion BD
        Export::connect();        

        // la variable qui va contenir les données CSV
        $outputCsv = '';

        // Nom du fichier qu'on initialise puis qu'on attribue
        $fileName = "ExportUserBD_".date('d/m/Y').".csv";
        
        // La requête récupère tous les utilisateurs
        $requete = Utilisateur::getAllObjectsExportBD();
       
        // Ecriture dans la variable CSV de la requête (voir le système CSV)
        $outputCsv=  Export::exportExcel($requete, $outputCsv);        
        
        // Formatage du document           
        Util::headerExcel($fileName);

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
       
        
        $database="BdEchoppe";
        
        // Connexion BD
        Export::connect();

        // la variable qui va contenir les données CSV
        $outputCsv = '';

        // Nom du fichier qu'on initialise puis qu'on attribue
        $fileName = "ExportArticleBD_".date('d/m/Y').".csv";
        
        // La requête récupère tous les articles
        $requete = Article::getAllObjectsExportBD();
        
        // Ecriture dans la variable CSV de la requête (voir le système CSV)
        $outputCsv=Export::exportExcel($requete, $outputCsv);
        
        // Formatage du fichier         
        Util::headerExcel($fileName);

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
