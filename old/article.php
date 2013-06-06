<?php
require_once('def.php');
require_once('Model/Article.php');
require_once('Model/PhotoArticle.php');
require_once('Model/Categorie.php');
require_once('Model/Admin.php');
include('Libs/SimpleImage.php');

function createArticlePics($files) {
    /* Initialisation des paramètres d'upload de l'image */
    $max_file_size = 3145728; // 3 Mo
    $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
    $nom_image = "";
    $image = "";
    /* Traitement de l'image uploadée */
    if (isset($files['image']) && !($files['image']['error'] > 0) && ($files['image']['size'] < $max_file_size)) {
        $extension_uploaded = strtolower(substr(strrchr($files['image']['name'], '.'), 1));
        if (in_array($extension_uploaded, $extensions_valides)) {
            $nom_image = md5(uniqid(rand(), true));
            $image = $nom_image.'.'.$extension_uploaded;
            /* Image agrandie */
            $url_image = 'produits/agrandies/'.$image;
            $resultat = move_uploaded_file($files['image']['tmp_name'], $url_image);
            /* Vignette */
            $vignette = new SimpleImage();
            $vignette->load($url_image);
            $vignette->resizeToWidth(160);
            $url_vignette = 'produits/vignettes/'.$nom_image.'.'.$extension_uploaded;
            $vignette->save($url_vignette);
        }
    }
    return $image;
}

class articleController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    function ajouter() {
        /* Authentication required */
        if (!Admin::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Ajouter un article */
        if(isset($_POST['ajouter']) && isset($_GET['idcat'])) {
            /* Sécurité (?) */
            $s_reference = addslashes($_POST['reference']);
            $s_nom = addslashes($_POST['nom']);
            $f_hauteur = addslashes($_POST['hauteur']);
            $f_largeur = addslashes($_POST['largeur']);
            $f_poids = addslashes($_POST['poids']);
            $f_prixGros = addslashes($_POST['prixGros']);
            $f_prixDetail = addslashes($_POST['prixDetail']);
            $i_qteR = addslashes($_POST['qteR']);
            $i_qteV = addslashes($_POST['qteV']);
            $i_idCategorie = addslashes($_GET['idcat']);
            /* Crée l'article */
            $i_idArticle = Article::create($s_reference, $s_nom, $f_hauteur, $f_largeur, $f_poids, $f_prixGros, $f_prixDetail, $i_qteR, $i_qteV, $i_idCategorie);
            /* Crée la photo agrandie et la vignette */
            if (isset($_FILES['image']['name']) && ($_FILES['image']['name'] != null)) {
                $s_nomImage = createArticlePics($_FILES);
                PhotoArticle::create($s_nomImage, $i_idArticle);
            }
            header('Location: ' . root . '/article.php/afficher?idcat='.$i_idCategorie);
        }
        /* Afficher la page d'ajout d'un article */
        else if(isset($_GET['idcat'])) {
            $i_idCategorie = $_GET['idcat'];
            $o_categorie = Categorie::getObject($i_idCategorie);
            $this->render('addNewArticle', compact('o_categorie'));
        } /* Défaut */
        else {
            header('Location: ' . root . '/article.php');
        }
    }

    function modifier() {
        /* Authentication required */
        if (!Admin::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Modifier un article */
        if (isset($_POST['modifier']) and isset($_GET['id']) and isset($_POST['idcat'])) {
            $i_idArticle = htmlentities($_GET['id']);
            $i_idCategorie = htmlentities($_POST['idcat']);
            //TODO : ajout de plusieurs photos possible
            /* Si la photo de l'article a été modifiée */
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                //TODO : autoriser la suppression d'une photo
                /* Supprime toutes les images agrandies et en vignette de l'article */
                $to_photoArticles = PhotoArticle::getObjectsByIdArticle($i_idArticle);
                foreach ($to_photoArticles as $o_photoArticle) {
                    $s_nomImage = $o_photoArticle['nomImage'];
                    unlink("produits/agrandies/".$s_nomImage);
                    unlink("produits/vignettes/".$s_nomImage);
                    PhotoArticle::deleteByIdArticle($i_idArticle);
                }
                /* Crée la nouvelle photo agrandie et vignette */
                $s_nomImage = createArticlePics($_FILES);
                /* MAJ dans la BD */
                PhotoArticle::create($s_nomImage, $i_idArticle);
            }
            /* Sécurité */
            $s_reference = addslashes($_POST['reference']);
            $s_nom = addslashes($_POST['nom']);
            $f_hauteur = addslashes($_POST['hauteur']);
            $f_largeur = addslashes($_POST['largeur']);
            $f_poids = addslashes($_POST['poids']);
            $f_prixGros = addslashes($_POST['prixGros']);
            $f_prixDetail = addslashes($_POST['prixDetail']);
            $i_qteR = addslashes($_POST['qteR']);
            $i_qteV = addslashes($_POST['qteV']);
            $i_idCategorie = addslashes($_POST['idCategorie']);
            /* MAJ dans la BD */
            Article::set($i_idArticle, $s_reference, $s_nom, $f_hauteur, $f_largeur, $f_poids, $f_prixGros, $f_prixDetail, $i_qteR, $i_qteV, $i_idCategorie);
            /* Redirection vers la catégorie de l'article */
            header('Location: ' . root . '/article.php/afficher?idcat='.$i_idCategorie);
        }
        /* Afficher la page de modification d'un article */
        else if (isset($_GET['id'])) {
            $i_idArticle = $_GET['id'];
            $o_article = Article::getObject($i_idArticle);
            $to_categories = Categorie::getAllObjects();
            /* Affecte les photos à l'article */
            $to_photoArticles = PhotoArticle::getObjectsByIdArticle($i_idArticle);
            foreach ($to_photoArticles as $o_photoArticle) {
                $o_article['ts_photos'][] = $o_photoArticle['nomImage'];
            }
            /* Render */
            $this->render('updateArticle', compact('o_article', 'to_categories'));
        }
        /* Défaut */
        else {
            header('Location: ' . root . '/article.php');
        }
    }

    function supprimer() {
        // Authentication required
        if (!Admin::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Annulation */
        if (isset($_POST['annuler']) && isset($_POST['idcat'])) {
            $i_idCategorie = htmlentities($_POST['idcat']);
            header('Location: ' . root . '/article.php/afficher?idcat='.$i_idCategorie);
        }
        // Supprimer l'article
        else if(isset($_GET['id']) and isset($_POST['supprimer']) and isset($_POST['idcat'])) {
            /* Sécurité */
            $i_idArticle = htmlentities($_GET['id']);
            $i_idCategorie = htmlentities($_POST['idcat']);
            /* Supprime toutes les images agrandies et en vignette de l'article */
            $to_photoArticles = PhotoArticle::getObjectsByIdArticle($i_idArticle);
            foreach ($to_photoArticles as $o_photoArticle) {
                $s_nomImage = $o_photoArticle['nomImage'];
                unlink("produits/agrandies/".$s_nomImage);
                unlink("produits/vignettes/".$s_nomImage);
                PhotoArticle::deleteByIdArticle($i_idArticle);
            }
            /* Supprime l'article */
            Article::delete($i_idArticle);
            /* Revient à la catégorie de l'article supprimé */
            header('Location: ' . root . '/article.php/afficher?idcat='.$i_idCategorie);
        } 
        /* Page de suppression de l'article */
        else if(isset($_GET['id'])) {
            $i_idArticle = $_GET['id'];
            $o_article = Article::getObject($i_idArticle);
            /* Affecte les photos à l'article */
            $to_photoArticles = PhotoArticle::getObjectsByIdArticle($i_idArticle);
            foreach ($to_photoArticles as $o_photoArticle) {
                $o_article['ts_photos'][] = $o_photoArticle['nomImage'];
            }
            $s_categorie = Categorie::getNom($o_article['idCategorie']);
            $this->render('deleteArticle', compact('o_article', 's_categorie'));
        }
        /* Défaut */
        else {
            header('Location: ' . root . '/article.php');
        }
    }

    public function afficher() {
        /* Authentication required */
        if (!Admin::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Afficher la liste des articles */
        if(isset($_GET['idcat'])) {
            $to_articles = Article::getObjectsByIdCategorie($_GET['idcat']);
            /* Affecte les photos aux articles */
            foreach ($to_articles as &$o_article) {
                $i_idArticle = $o_article['id'];
                $to_photoArticles = PhotoArticle::getObjectsByIdArticle($i_idArticle);
                foreach ($to_photoArticles as $o_photoArticle) {
                    $o_article['ts_photos'][] = $o_photoArticle['nomImage'];
                }
            }
            $o_categorie = Categorie::getObject($_GET['idcat']);
            $this->render('showArticlesByCategorie', compact('to_articles', 'o_categorie'));
        }
        /* Défaut */
        else {
            header('Location: ' . root . '/article.php');
        }
    }

    public function defaultAction() {
        /* Authentication required */
        if (!Admin::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        $this->render('accueil', null);
    }
}
new articleController();
?>
