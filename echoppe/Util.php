<?php
class Util {

    /* 
     * Fonction pour envoyer un mail.
     */
    public static function sendEmail($s_destinataire, $s_subject, $s_message) {
        /* Header */
        $s_header  = 'MIME-Version: 1.0'."\r\n";
        $s_header .= 'Content-type: text/html; charset=utf-8'."\r\n";
        $s_header .= 'From:'.email_owner."\r\n"; // a changer
        /* Contenu */
        $s_contenu  = "<html>\n\t<head>\n\t</head>\n\t<body>\n\t\t";
        $s_contenu .= "<p> [ Message du site : ".url_site." ] </p>\n" ;
        $s_contenu .= "<p>".$s_message."</p>\n" ;
        $s_contenu .= "\t</body>\n</html>";
        // Envoie du mail
       if(! mail($s_destinataire, $s_subject, $s_contenu, $s_header))
           {echo "Echec de l'envoi à $s_destinataire <br/>";}
    }
    
    public static function headerExcel($fileName) {
        /* Fonction qui permet le formatage d'un fichier excel */
        header("Content-disposition: attachment; filename=".$fileName);
        header("Content-Type: application/force-download");
        header("Content-Transfer-Encoding: application/vnd.ms-excel\n");
        header("Pragma: no-cache");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
        header("Expires: 0");
    }

    public static function trim_str($in_str){
        return substr(html_entity_decode($in_str,ENT_COMPAT,"ISO-8859-1"),0,29);
    }
}?>