<?php
session_start();
require_once("Model/ConnexionBD.php");

abstract class Controller {

    private function root() {
        return dirname(__FILE__);
    }

    private function logged() {
        return isset($_SESSION['logged']) && $_SESSION['logged'];
    }

    protected function setRootWebApp(){
        // Définition d'une constante nommée root permettant de reconnaître
        // la racinde l'application. Ceci est pratique dans les vues lors
        // de l'appel de contrôleurs. Voir un exemple d'usage de root dans
        // index.view.php.
        preg_match('@/[^/]+@', $_SERVER["PHP_SELF"], $matches);
        defined('root') || define('root', $matches[0]);
    }

    protected function render($file_name, $variables_array = null) {
        // permet de communiquer des variables du controller à la vue,
        // en ajoutant le header et le footer (ce dernier contient le menu)
        // à la vue.
        if($variables_array) {
           extract($variables_array);
        }
        include($this->root() . '/Layouts/header.php');
        require($this->root() . '/Views/' . $file_name . '.view.php');
        include($this->root() . '/Layouts/footer.php');
    }

    // Les 2 fonctions suivantes permettent de simuler des "jointures"
    // entre 2 tables de la base de données

    protected function extractColumn($to_array, $s_indCol){
        // $to_array est le tableau dont la colonne nommée $s_indCol est 
        // retournée par cette fonction
        // pour PHP < 5.5.0 la fonction array_column n'existe pas.
        $i_nbLigne = count($to_array);
        for($i_numLigne = 0; $i_numLigne < $i_nbLigne; $i_numLigne++){
            $t_col[] = $to_array[$i_numLigne][$s_indCol];
        }
        return $t_col;
    }

    protected function selectionLine(&$to_array, $s_indCol, $t_col){
        // $to_array est le tableau qu'on affine (modifié en sortie) dont la 
        // colonne nommée $s_indCol ne prend que les valeurs indiquées dans
        // le tableau $t_col.
        $i_nbLigne = count($to_array);
        for($i_numLigne = 0; $i_numLigne < $i_nbLigne; $i_numLigne++){
            $elt_cour = $to_array[$i_numLigne][$s_indCol];
            $val = array_search($elt_cour,$t_col);
            // les colonnes ne sont pas indicées par des booleans
            // si le type de $val est boolean nécessairement
            // array_search a retourné FALSE (n'a pas trouvé la 
            // $elt_cour qu'elle cherchait dans $t_col).
            if(gettype($val) == "boolean"){
                unset($to_array[$i_numLigne]);
            }
        }
    }

    abstract function defaultAction();

    private function executeAction(){
        $action = substr(strrchr($_SERVER["PHP_SELF"], "/"), 1);
        (strpos($action, ".php")) ? $this->defaultAction() : $this->$action();
    }

    // Appel à un contrôleur avec une action qui n'existe pas
    function __call($name, $arguments){
        echo "<b>Erreur : </b> L'action $name n'est pas définie";
    }

    public function __construct() {
        defined('connect') || connexion_bd();
        $this->setRootWebApp();
        //Exécution de l'action demandée du contrôleur
        $this->executeAction();
    }
}

?>
