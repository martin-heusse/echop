<?php
class Utilisateur {

    public static function authentication($s_login, $s_motDePasse) {
        $sql_query = "select id from utilisateur where lower(login)=lower('$s_login') and mot_de_passe='$s_motDePasse' and validite=1";
        $sql_tmp = mysql_query($sql_query);
        $i_result = false;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            $i_result = $o_row['id'];
        }
        return $i_result;
    }

    public static function isLogged() {
        $b_result = (isset($_SESSION['login']));
        return $b_result;
    }

    /* Creaters */

    public static function create($s_login, $s_motDePasse, $s_email,$b_validite) {
        $sql_query = "insert into utilisateur(login, mot_de_passe, email,validite) 
            values('$s_login', '$s_motDePasse', '$s_email','$b_validite')";
        mysql_query($sql_query);
        $i_result = mysql_insert_id();
        return $i_result;
    }

    /* Getters */

    public static function getAllObjects() {
        $sql_query = "select * from utilisateur";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null,'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getAllEmail() {
            $sql_query = "select email from utilisateur";
            $sql_tmp = mysql_query($sql_query);
            $ts_result = array();
            while ($o_row = mysql_fetch_assoc($sql_tmp)) {
                /* Sécurité */
                foreach ($o_row as &$column) {
                    $column = htmlentities($column, null,'UTF-8');
                }
                /* Création du résultat */
                $ts_result[] = $o_row['email'];
            }
            return $ts_result;
    }

    public static function getObjectsByLogin($s_login) {
        $sql_query = "select * from utilisateur where lower(login)=lower('$s_login')";
        $sql_tmp = mysql_query($sql_query);
        $to_result = array();
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null,'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }

    public static function getObjectByLogin($s_login) {
        $sql_query = "select * from utilisateur where login ='$s_login'";
        $sql_temp = mysql_query($sql_query);
        $o_result = null;

        if ($o_row = mysql_fetch_assoc($sql_temp)) {
            
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null,'UTF-8');
            }

            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getObject($i_id) {
        $sql_query = "select * from utilisateur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $o_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                $column = htmlentities($column, null,'UTF-8');
            }
            /* Création du résultat */
            $o_result = $o_row;
        }
        return $o_result;
    }

    public static function getLogin($i_id) {
        $sql_query = "select login from utilisateur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['login'], null,'UTF-8');
        }
        return $s_result;
    }

    public static function getMotDePasse($i_id) {
        $sql_query = "select mot_de_passe from utilisateur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['mot_de_passe'], null,'UTF-8');
        }
        return $s_result;
    }

    public static function getEmail($i_id) {
        $sql_query = "select email from utilisateur where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $s_result = htmlentities($o_row['email'], null,'UTF-8');
        }
        return $s_result;
    }
    
    public static function getObjectsByValidite($b_validite) {
        $sql_query = "select * from utilisateur where validite=$b_validite order by login";
        $sql_tmp = mysql_query($sql_query);
        $to_result = null;
        while ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité */
            foreach ($o_row as &$column) {
                    $column = htmlentities($column, null,'UTF-8');
            }
            /* Création du résultat */
            $to_result[] = $o_row;
        }
        return $to_result;
    }    
    
    public static function getCountByValidite($b_validite) {
        $sql_query = "select count(*) number from utilisateur where validite=$b_validite";
        $sql_tmp = mysql_query($sql_query);
        $i_result = 0;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            /* Sécurité et création du résultat */
            $i_result = htmlentities($o_row['number'], null,'UTF-8');
        }
        return $i_result;
    }


    /* Setters */

    public static function set($i_id, $s_login, $s_motDePasse, $s_email) {
        $sql_query = "update utilisateur set login='$s_login', mot_de_passe='$s_motDePasse', email='$s_email' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setLogin($i_id, $s_login) {
        $sql_query = "update utilisateur set login='$s_login' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setMotDePasse($i_id, $s_motDePasse) {
        $sql_query = "update utilisateur set mot_de_passe='$s_motDePasse' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setEmail($i_id, $s_email) {
        $sql_query = "update utilisateur set email='$s_email' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    public static function setValidite($i_id, $b_validite) {
        $sql_query = "update utilisateur set validite='$b_validite' 
            where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }

    /* Deleters */

    public static function delete($i_id) {
        $sql_query = "delete from utilisateur where id=$i_id";
        $b_result =  mysql_query($sql_query);
        return $b_result;
    }
}
?>
