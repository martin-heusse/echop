<?php
require_once('def.php');
require_once('Util.php');
require_once('Model/Export.php');
require_once('Model/Commande.php');
require_once('Model/Campagne.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Article.php');
require_once('Model/Unite.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/ArticleFournisseur.php');
require_once('Model/Rayon.php');
require_once('Model/Fournisseur.php');
require_once('FPDF/fpdf.php');

/*
 * Gère "Mes commandes" des utilisateurs en tant qu'utilisateur.
 */
class MesCommandesController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche les commandes de l'utilisateur courant.
     */
    public function mesCommandes() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Récupération de l'identifiant de la campagne courante */
        
        $i_idCampagne = Campagne::getIdCampagneCourante();
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur = $_SESSION['idUtilisateur'];
        $to_commande = Commande::getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);
        /* Montant total */
        $f_montantTotal = 0;
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
            
            /* Récupération du Code Fournisseur, 1&2 cahier des charges */
            $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idFournisseur = ArticleCampagne::getIdFournisseur($i_idArticleCampagne);
            //$o_article_fournisseur = ArticleFournisseur::getObjectByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $i_idArticleFournisseur = ArticleFournisseur::getIdByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $o_article['code'] = ArticleFournisseur::getCode($i_idArticleFournisseur);
            
            
            
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
            $f_montantTotal += $o_article['total_ttc'];
            /* Formattage des nombres */
            $o_article['prix_unitaire'] = number_format($o_article['prix_unitaire'], 2, '.', '');
            $o_article['quantite_totale'] = number_format($o_article['quantite_totale'], 2, '.', '');
            $o_article['total_ttc'] = number_format($o_article['total_ttc'], 2, '.', '');
            $f_montantTotal = number_format($f_montantTotal, 2, '.', '');
        }
        $this->render('mesCommandes', compact('to_commande', 'i_idCampagne', 'i_idUtilisateur', 'b_etat', 'f_montantTotal'));
    }

    
    
    public function mesVieillesCommandes() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Récupération de l'identifiant de la campagne souhaité */
        $i_idCampagne = $_GET['id_camp'];
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur = $_SESSION['idUtilisateur'];
        $to_commande = Commande::getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);
        /* Montant total */
        $f_montantTotal = 0;
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
            
            /* Récupération du Code Fournisseur, 1&2 cahier des charges */
            $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idFournisseur = ArticleCampagne::getIdFournisseur($i_idArticleCampagne);
            //$o_article_fournisseur = ArticleFournisseur::getObjectByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $i_idArticleFournisseur = ArticleFournisseur::getIdByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $o_article['code'] = ArticleFournisseur::getCode($i_idArticleFournisseur);
            
            
            
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
            $f_montantTotal += $o_article['total_ttc'];
            /* Formattage des nombres */
            $o_article['prix_unitaire'] = number_format($o_article['prix_unitaire'], 2, '.', '');
            $o_article['quantite_totale'] = number_format($o_article['quantite_totale'], 2, '.', '');
            $o_article['total_ttc'] = number_format($o_article['total_ttc'], 2, '.', '');
            $f_montantTotal = number_format($f_montantTotal, 2, '.', '');
        }
        $this->render('mesCommandes', compact('to_commande', 'i_idUtilisateur', 'i_idCampagne', 'b_etat', 'f_montantTotal'));
    }

    
    
    
    
    /*
     * Gère la modification des quantités dans "mes commandes" de la commande
     * de l'utilisateur courant.
     */
    public function mesCommandesModifier() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = Campagne::getIdCampagneCourante();
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* La campagne est fermée */
        if ($b_etat == 0) {
            header('Location: '.root.'/mesCommandes.php/mesCommandes');
            return;
        }
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur = $_SESSION['idUtilisateur'];
        /* Récupération des articles de l'utilisateur */
        $ti_article = Commande::getIdArticleByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);
        /* Pour chaque article on modifie la quantité si nécéssaire */
        foreach($ti_article as &$i_article) {
            $i_idArticle = $i_article['id_article'];
            /* Si des modifications ont été faite par l'utilisateur, on traite l'entrée */
            if (isset($_POST['quantite'])){
                $ti_quantite = $_POST['quantite'];
                $i_quantite = $ti_quantite[$i_idArticle];
                $i_seuilMin = ArticleCampagne::getSeuilMinByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                /* Si la quantité est supérieur au seuil min et non nulle, on 
                 * actualise, sinon on ne fait rien */
                if ($i_quantite != 0 && $i_quantite >= $i_seuilMin) {
                    $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                    Commande::setQuantite($i_idCommande, $i_quantite);
                }
            }	
        }
        /* Redirection */
        header('Location: '.root.'/mesCommandes.php/mesCommandes');
    }

    /*
     * Supprime l'article de l'utilisateur courant.
     */
    public function mesCommandesSupprimer() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = Campagne::getIdCampagneCourante();
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* La campagne est fermée */
        if ($b_etat == 0) {
            header('Location: '.root.'/mesCommandes.php/mesCommandes');
            return;
        }
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur = $_SESSION['idUtilisateur'];
        /* Récupération de l'id article à supprimer */
        $i_idArticle = $_GET['id_article'];
        $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
        Commande::delete($i_idCommande);
        /* Redirection */
        header('Location: '.root.'/mesCommandes.php/mesCommandes');
    }
    
    public function exportCSV() {
        
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur = $_SESSION['idUtilisateur'];
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = $_GET['id_camp'];
        //echo $i_idCampagne;
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        
        /*Récupération Nom et Prénom de l'Utilisateur*/
        $userLogin=Utilisateur::getLogin($i_idUtilisateur);
        $userName=Utilisateur::getNom($i_idUtilisateur);
        $userSurname=Utilisateur::getPrenom($i_idUtilisateur);
        
        // Nom BD
        $database="BdEchoppe";
        
        // Connexion BD
        Export::connect();

        // la variable qui va contenir les données CSV
        $outputCsv = '';

        // Nom du fichier qu'on initialise puis qu'on attribue
        $fileName = "Commande_".$userLogin."_".$userName."_".$userSurname."_campagne".$i_idCampagne.".csv";
        
        // Deux requêtes : une qui exporte les données de la commande, l'autre le total TTC
        $j=0;
        while($j<2){
            if($j == 0)
                {
                    $requete = Commande::getExportCSVDatas($i_idUtilisateur, $i_idCampagne);
                }else{
                    $requete= Commande::getExportCSVTotalTTC($i_idUtilisateur, $i_idCampagne);
                }
        
            // Ecriture dans la variable CSV de la requête (voir le système CSV)       
            $outputCsv=Export::exportExcel($requete, $outputCsv);
        
            // Passage à la requête suivante
             $j=$j+1;
        }
        
        // Formatage du fichier
        Util::headerExcel($fileName);

        echo $outputCsv;
        exit();
    }
    
    public function exportPDF() {
        
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Récupération des articles commandés par l'utilisateur courant */
        $i_idUtilisateur = $_SESSION['idUtilisateur'];
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = $_GET['id_camp'];
        //echo $i_idCampagne;
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);

        /*Récupération Nom et Prénom de l'Utilisateur*/
        $userLogin=Utilisateur::getLogin($i_idUtilisateur);
        $userName=Utilisateur::getNom($i_idUtilisateur);
        $userSurname=Utilisateur::getPrenom($i_idUtilisateur);
        
        //echo $userLogin;
        //echo $userName;
        //echo $userSurname;
        //echo $i_idCampagne;
        
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
        $header=array('Produit','Description','Code fournisseur', 'Poids paquet fournisseur','Nombre paquet par colis','Prix TTC','Prix TTC unitaire',
        'Quantite min commande','Quantite','Quantite totale commandee',
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
            /* Récupération du Code Fournisseur*/
            $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idFournisseur = ArticleCampagne::getIdFournisseur($i_idArticleCampagne);
            //$o_article_fournisseur = ArticleFournisseur::getObjectByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $i_idArticleFournisseur = ArticleFournisseur::getIdByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $o_article['code'] = ArticleFournisseur::getCode($i_idArticleFournisseur);
            


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
            $pdf->cell(3.5,0.7,$o_article['code'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['poids_paquet_fournisseur'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['nb_paquet_colis'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['prix_ttc'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['prix_unitaire'],1,0,'C',$fond);
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
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/mesCommandes.php/mesCommandes');
    }
}
new MesCommandesController();
?>
