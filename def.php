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
        // index.view.php
        preg_match('@/[^/]+@', $_SERVER["PHP_SELF"], $matches);
        defined('root') || define('root', $matches[0]);
    }
    
    protected function render($file_name, $variables_array = null) {	
        if($variables_array) {
           extract($variables_array);
        }
        include($this->root() . '/Layouts/header.php');
        require($this->root() . '/Views/' . $file_name . '.view.php');
        include($this->root() . '/Layouts/footer.php');
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
