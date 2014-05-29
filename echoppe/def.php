<?php
session_start();
require_once("Model/ConnexionBD.php");
require_once "constants.php";

abstract class Controller {

    /*
     * Renvoie le chemin absolu de répertoire courant contenant ce fichier
     * def.php, soit la racine du projet.
     */
    private function root() {
        return dirname(__FILE__);
    }

    /*
     * Définition d'une constante nommée root permettant de reconnaître
     * la racin de l'application. Ceci est pratique dans les vues lors
     * de l'appel de contrôleurs. Voir un exemple d'usage de root dans
     * index.view.php.
     */
    protected function setRootWebApp(){
        defined('root') || define('root', url_site);
    }

    /* 
     * Permet de communiquer des variables du controller à la vue,
     * en ajoutant le header.php et le footer.php (le header.php contient le 
     * Layout/menu.php) à la vue.
    */
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
