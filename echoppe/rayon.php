<?php
require_once('def.php');
require_once('Model/Rayon.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Categorie.php');

class RayonController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche tous les rayons et toutes les catégories
     */
    public function afficherRayon() {
        /* liste des rayons à afficher */
        $to_categorie = Categorie::getAllObjects();
        $to_rayon = Rayon::getAllObjects();
        $this->render('gererRayon', compact('to_rayon','to_categorie'));
        return;
    }

    /*
     * Crée un rayon et la marge associée
     */
    public function creerRayon() {

        $i_rayonSet = 0;
        $i_errName = 0;
        $i_errMarge = 0;

        /* Authentification required */
        if (!Utilisateur::isLogged()) {
            header('Location: '.root.'/authentificationRequired');
        }

        /* Gestion du formulaire */
        if (isset($_POST['nomRayon']) && $_POST['nomRayon'] != "" && isset($_POST['marge']) && $_POST['marge'] != "") {
            $s_nomRayon = $_POST['nomRayon'];
            $f_marge = $_POST['marge'];

            /* Vérification de la disponibilité du nom */
            $o_nom = Rayon::getObjectByNom($s_nomRayon);

            if ($o_nom != array()) {
                $i_errName = 1;
                $this->render('creerRayon',compact('i_errMarge','i_errName'));
                return;
            } else {
                $i_rayonSet = 1;

                /* Vérification de la marge */
                if ($f_marge < 0 || $f_marge > 100) {
                    $i_errMarge = 1;
                    $this->render('creerRayon',compact('i_errMarge','i_errName'));
                    return;
                } else {
                    $f_marge /= 100;
                    Rayon::create($s_nomRayon,$f_marge);
                }

            }
            $to_rayon = Rayon::getAllObjects();
            $to_categorie = Categorie::getAllObjects();
            $this->render('gererRayon', compact('i_errMarge','i_errName','to_rayon','to_categorie'));
            return;
        }


        $this->render('creerRayon',compact('i_rayonSet','i_errName','i_errMarge'));
        return;
    }


    /*
     * Modifie le nom et/ou la marge d'un rayon
     */
    public function modifierRayon() {
        $i_errNewName = 0;
        $i_oldRayonSet = 0;
        $to_rayon = Rayon::getAllObjects();
        $i_idRayon = 0;
        $i_errMarge = 0;
        $i_change = 0;

        /* Authentification required */
        if (!Utilisateur::isLogged()) {
            header('Location: '.root.'/authentificationRequired');
        }

        /* Récupération de l'id du rayon à modifier */
        if (isset($_GET['idRayon']) && $_GET['idRayon'] != "") {
            $i_oldRayonSet = 1;
            $i_idRayon = $_GET['idRayon'];
            $s_Rayon = Rayon::getNom($i_idRayon); 
            $f_marge = 100*Rayon::getMarge($i_idRayon);
            $this->render('modifierRayon',compact('f_marge','s_Rayon','i_idRayon','i_errNewName','i_oldRayonSet','to_rayon'));
            return;
        }

        /* Gestion de la modification de la marge */
        if (isset($_POST['marge']) && $_POST['marge'] != "") {
            $f_marge = $_POST['marge'];
            $i_id = $_POST['idRayon'];

            /* Vérification de la marge */
            if ($f_marge < 0 || $f_marge > 100) {
                $i_errMarge = 1;
            } else {
                $f_marge /= 100;
                Rayon::setMarge($i_id,$f_marge);
            }
            $i_change = 1;
        }

        /* Gestion de la modification du nom */
        if (isset($_POST['newNomRayon']) && $_POST['newNomRayon'] != "") {
            $s_nomRayon = $_POST['newNomRayon'];
            $i_id = $_POST['idRayon'];

            /* Vérification de la disponibilité du nom */ 
            $o_nom = Rayon::getObjectByNom($s_nomRayon);

            if ($o_nom != array()) {
                $i_errNewName = 1;
                $i_oldRayonSet = 1;
            } else {
                Rayon::setNom($i_id,$s_nomRayon);
            }
            $i_change = 1;
        }

        $to_rayon = Rayon::getAllObjects();

        /* Gestion des modifications et de leur conformité pour la vue */
        if ($i_change != 0 && $i_errMarge == 0 && $i_errNewName && $i_errMarge == 0) {    
            $to_categorie = Categorie::getAllObjects();
            $this->render('gererRayon', compact('to_rayon','to_categorie'));
            return;
        }
        $this->render('modifierRayon',compact('i_errNewName','i_oldRayonSet','to_rayon', 's_nomRayon'));
        return;
    }

    /*
     * A implémenter
     */
    
        public function exportPDF() {
        
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

        /* Récupération des articles commandés par l'utilisateur */
        if (!isset($_GET['idUtilisateur'])) {
            header('Location: '.root.'/utilisateurAyantCommandE.php/utilisateurAyantCommandE');
        }
        $i_idUtilisateur = $_GET['idUtilisateur']; 
        //echo $i_idUtilisateur;
        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        /*Récupération Nom et Prénom de l'Utilisateur*/
        $userLogin=Utilisateur::getLogin($i_idUtilisateur);
        $userName=Utilisateur::getNom($i_idUtilisateur);
        $userSurname=Utilisateur::getPrenom($i_idUtilisateur);
                
        /*Titre de la page PDF qui se charge, apparait dans le titre de la page Web*/
        $docTitle="Recapitulatif de commande de ".$userLogin." ".$userName." ".$userSurname." pour la campagne ".$i_idCampagne;
        
        /*Création du PDF*/
        $pdf=new FPDF('L','cm','A3');
        $pdf->Open();
        $pdf->SetTitle($docTitle);
        
        /*Titre du document*/
        $pdf->SetFont('Arial','UB',14);
        $pdf->AddPage();
        $pdf->Write(5,$docTitle);
        
        /*Titres des colonnes*/
        $header=array('Produit','Description','Poids paquet fournisseur','Nombre paquet par colis','Prix TTC','Prix TTC unitaire',
            'Poids unit commande client','Quantite min commande','Quantite','Quantite totale commandee',
            'Total TTC');
        $pdf->SetFont('Arial','B',7);
        $pdf->SetFillColor(96,96,96);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY(2,5);
        for($i=0;$i<sizeof($header);$i++)
                $pdf->cell(3.5,1,$header[$i],1,0,'C',1);
        
        /* On recupère la commande d'un utilisateur */
        $to_commande = Commande::getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);
        
        /* Montant total */
        $f_montantTotal = 0;
        $f_montantParRayon = NULL;
        
        /* Récupération de tous les attributs nécessaires d'un article */
        foreach($to_commande as &$o_article) {
            /* Attributs dépendant de l'article */
            $i_idArticle = $o_article['id_article'];
            $o_article['nom'] = Article::getNom($i_idArticle);
            $o_article['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
            $i_idUnite = Article::getIdUnite($i_idArticle);
            $o_article['unite'] = Unite::getUnite($i_idUnite);
            $o_article['nb_paquet_colis'] = Article::getNbPaquetColis($i_idArticle);
            $o_article['description_courte'] = Article::getDescriptionCourte($i_idArticle);
            $o_article['description_longue'] = Article::getDescriptionLongue($i_idArticle);
            /* Prix TTC, seuil min et poids paquet client */
            $o_article_campagne = ArticleCampagne::getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $o_article['prix_ttc'] = $o_article_campagne['prix_ttc'];
            $o_article['seuil_min'] = $o_article_campagne['seuil_min'];
            $o_article['poids_paquet_client'] = $o_article_campagne['poids_paquet_client'];

            /* Valeurs calculées */
            /* Calcul poids unitaire */
            $o_article['prix_unitaire'] = $o_article['prix_ttc'] / $o_article['poids_paquet_fournisseur'];
            /* Calcul quantité totale */
            $o_article['quantite_totale'] = $o_article['quantite'] * $o_article['poids_paquet_client'];
            /* Calcul total TTC */
            $o_article['total_ttc'] = $o_article['quantite_totale'] * $o_article['prix_ttc'] / $o_article['poids_paquet_fournisseur'];
            /* Calcul du montant total */
            $f_montantTotal += (float) $o_article['total_ttc'];
            if(isset($f_montantParRayon[$o_article['nom_rayon']]))
                $f_montantParRayon[$o_article['nom_rayon']]+=(float) $o_article['total_ttc'];
            else 
                $f_montantParRayon[$o_article['nom_rayon']]=(float) $o_article['total_ttc'];
            /* Formattage des nombres */
            $o_article['prix_unitaire'] = number_format($o_article['prix_unitaire'], 2, '.', '');
            $o_article['quantite_totale'] = number_format($o_article['quantite_totale'], 2, '.', '');
            $o_article['total_ttc'] = number_format($o_article['total_ttc'], 2, '.', '');
            $f_montantTotal = number_format($f_montantTotal, 2, '.', '');
           

            $pdf->SetFillColor(0xdd,0xdd,0xdd);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);
            $pdf->SetXY(2,$pdf->GetY()+1);
            $fond=0;
        
            $pdf->cell(3.5,0.7,$o_article['nom'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['description_courte'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['poids_paquet_fournisseur'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['nb_paquet_colis'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['prix_ttc'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['prix_unitaire'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['poids_paquet_client'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['seuil_min'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['quantite'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['quantite_totale'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['total_ttc'],1,0,'C',$fond);
            $pdf->SetXY(3.5,$pdf->GetY()+0);
            $fond=!$fond;
        }
                

        /*Montant total*/
        $Montant_Total="Total : ".$f_montantTotal." Euros";
        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY(37,$pdf->GetY()+1);
        $pdf->cell(3.5,0.7,$Montant_Total,1,0,'C',$fond);
        
        /*Fin PDF*/
        $pdf->output();
    }
    
    /*
     * Action par défaut 
     */
    public function defaultAction() {
        header('Location: '.root.'/rayon.php/creerRayon');
    }
}
new RayonController();
?>
