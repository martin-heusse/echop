<?php
class Admin {

    public static function authentication($s_login, $s_password) {
        $sql_query = "select id from Admin where lower(login)=lower('$s_login') and password='$s_password'";
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

    public static function getLogin($i_id) {
        $sql_query = "select login from Admin where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            $s_result = $o_row['login'];
        }
        return $s_result;
    }

    public static function getNom($i_id) {
        $sql_query = "select nom from Admin where id=$i_id";
        $sql_tmp = mysql_query($sql_query);
        $s_result = null;
        if ($o_row = mysql_fetch_assoc($sql_tmp)) {
            $s_result = $o_row['nom'];
        }
        return $s_result;
    }
}
?>
