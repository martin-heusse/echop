<?php

require_once('def.php');
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
       
        // Connexion BD
        $database="BdEchoppe";
        mysql_connect(db_host, db_username,db_pwd);
        mysql_select_db(db_name);

        // la variable qui va contenir les données CSV
        $outputCsv = '';

        // Nom du fichier qu'on initialise puis qu'on attribue
        $fileName = "Export".$database."_".date('d/m/Y').".csv";

        $result = mysql_list_tables($database);
        $num_rows = mysql_num_rows($result);
        for ($j = 0; $j < $num_rows; $j++) {
            $table=mysql_tablename($result, $j);
            

            $requete="Select * from $table";
            $sql=  mysql_query($requete);
            if(mysql_num_rows($sql) > 0)
            {
                $i = 0;

                while($Row = mysql_fetch_assoc($sql))
                {
                    $i++;

                    // Si c'est la 1er boucle, on affiche le nom de la table, et le nom des champs pour avoir un titre pour chaque colonne
                    if($i == 1)
                    {   
                        $outputCsv .= trim($table).';';
                        $outputCsv .= "\n";
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
       
        // Connexion BD
        $database="BdEchoppe";
        mysql_connect(db_host, db_username,db_pwd);
        mysql_select_db(db_name);

        // la variable qui va contenir les données CSV
        $outputCsv = '';

        // Nom du fichier qu'on initialise puis qu'on attribue
        $fileName = "ExportUserBD_".date('d/m/Y').".csv";
        
        // La requête récupère tous les utilisateurs
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
        $fileName = "ExportArticleBD_".date('d/m/Y').".csv";
        
       

        // La requête récupère tous les articles
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
         
//    public function importArticle() {
//        /* Authentication required */
//        if (!Utilisateur::isLogged()) {
//            $this->render('authenticationRequired');
//            return;
//        }
//        /* Doit être un administrateur */
//        if (!$_SESSION['isAdministrateur']) {
//            $this->render('adminRequired');
//            return;
//        }
//
//	if(isset($_FILES['csv']))
//	{ 
//		 $dossier = 'upload/';
//		 $fichier = basename($_FILES['csv']['name']);
//		 if(move_uploaded_file($_FILES['csv']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
//		 {
//			  echo "Upload du fichier effectué avec succès !";
//		 }
//		 else //Sinon (la fonction renvoie FALSE).
//		 {
//			  echo "Echec de l\'upload !";
//		 }
//	}
// 
//	echo "<br>Chemin du fichier : upload/".$_FILES['csv']['name']."<br><br>Resultat Import SQL : <br>";
// 
//	mysql_connect('localhost', 'root', '');
//	mysql_select_db('xls_db');
//	mysql_query("SET NAMES UTF8");
// 
//	//Le chemin d'acces a ton fichier sur le serveur
//	$fichier = fopen("upload/".$_FILES['csv']['name'], "r");
// 
//	//tant qu'on est pas a la fin du fichier :
//	while (!feof($fichier))
//	{
//	// On recupere toute la ligne
//	$uneLigne = addslashes(fgets($fichier));
//	//On met dans un tableau les differentes valeurs trouvés (ici séparées par un ';')
//	$tableauValeurs = explode(';', $uneLigne);
//	// On crée la requete pour inserer les donner (ici il y a 12 champs donc de [0] a [11])
//	$sql="INSERT IGNORE INTO histo VALUES ('".$tableauValeurs[0]."', '".$tableauValeurs[1]."', '".$tableauValeurs[2]."', '".$tableauValeurs[3]."', '".$tableauValeurs[4]."', '".$tableauValeurs[5]."', '".$tableauValeurs[6]."', '".$tableauValeurs[7]."')";
// 
//	$req=mysql_query($sql)or die (mysql_error());
//	// la ligne est finie donc on passe a la ligne suivante (boucle)
//	}
//	//vérification et envoi d'une réponse à l'utilisateur
//	if ($req)
//	{
//	echo "<h2>Ajout dans la base de données effectué avec succès</h2>";
//	}
//	else
//	{
//	echo "Echec dans l'ajout dans la base de données";
//	}
//        
//    }
    
    public function defaultAction() {
        header('Location: ' . root . '/utilisateur.php/listeUtilisateur');
        /*A changer*/
    }

}
new ExportController();
?>
