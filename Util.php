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
        $s_contenu .= "<p>".$s_message."</p>\n" ;
        $s_contenu .= "\t</body>\n</html>";
        // Envoie du mail
        mail($s_destinataire, $s_subject, $s_contenu, $s_header);
    }
}
?>

