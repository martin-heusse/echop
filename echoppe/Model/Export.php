<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Export {
    
    public static function exportExcel($requete, $outputCsv) {
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
                    $outputCsv .=  utf8_decode(str_replace(".",",",html_entity_decode(trim($valeur)))).';';

                // Suppression du ; qui traine à la fin
                $outputCsv = rtrim($outputCsv, ';');

                // Saut de ligne
                $outputCsv .= "\n";

            }
            // On retourne la variable qui est celle à laquelle de la suite on concatène tout
            return $outputCsv;
        }
        else
            exit('Aucune donnée à enregistrer.');
    }
    
    public static function exportExcelTitresTables($requete, $outputCsv, $table) {
        
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
            // On retourne la variable qui est celle à laquelle de la suite on concatène tout
            return $outputCsv;
        }
        else
            exit('Aucune donnée à enregistrer.');
    }
    
    public static function excelWrite($outputCsv, $valeur){
            // Ecrire la valeur dans la variable $outputCsv
            $outputCsv .= trim($valeur).';';
            return $outputCsv;
    }
    
    public static function excelJump($outputCsv){
            // Sauter une ligne
            $outputCsv .= "\n";
            return $outputCsv;
    }
    
    public static function excelDeletePoint($outputCsv){
            // Suppression du ; qui traine à la fin
            $outputCsv = rtrim($outputCsv, ';');
            return $outputCsv;
    }
    
    public static function connect(){
        /* Se connecte à la base de donnée*/
        mysql_connect(db_host, db_username,db_pwd);
        mysql_select_db(db_name);
    }
    
    public static function listeTables($database){
        /* Retourne le nom des tables de la BD*/
        return mysql_list_tables($database);
    }
    
    public static function numResultat($requete){
        /* Retourne le nombre de "row"*/
        return mysql_num_rows($requete);
    }
    
    public static function nomTable($requete, $j){
        /* Retourne le nom de la table $requete ayant le numéro $j*/
        return mysql_tablename($requete, $j);
    }
    
    public static function getAll($table){
        /* Retourne le nom de la table $requete ayant le numéro $j*/
        return "Select * from $table";
    }
    
}

