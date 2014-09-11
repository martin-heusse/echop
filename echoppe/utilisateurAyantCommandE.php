<?php
require_once('def.php');
require_once('Util.php');
require_once('FPDF/fpdf.php');
require_once('Model/Export.php');
require_once('Model/Commande.php');
require_once('Model/Campagne.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Article.php');
require_once('Model/Unite.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/Rayon.php');
require_once('Model/Fournisseur.php');
require_once('Model/ArticleFournisseur.php');

/*
 * Gère les commandes.
 */
class UtilisateurAyantCommandEController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche la liste de tous les utilisateurs ayant effectué une commande 
     * dans la campagne courante.
     */
    public function utilisateurAyantCommandE(){  
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
        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        /* On récupère l'ensemble des utilisateurs qui ont passé des commandes 
         */
        $to_commande = Commande::getIdUtilisateurUniqueByIdCampagne($i_idCampagne);
        foreach($to_commande as &$o_article) {
            /* Pour chaque utilisateur, on récupère les données nécéssaires */
            $i_idUtilisateur = $o_article['id_utilisateur'];
            $o_article['login_utilisateur'] = Utilisateur::getLogin($i_idUtilisateur);
            $o_article['nom'] = Utilisateur::getNom($i_idUtilisateur);
            $o_article['prenom'] = Utilisateur::getPrenom($i_idUtilisateur);

            $to_article = Commande::getIdArticleByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);
            /* A été livré ou non */
            $o_article['tout_livre'] = 0;
            if (Commande::getCountByEstLivreForIdCampagneIdUtilisateur(0, $i_idCampagne, $i_idUtilisateur) == 0) {
                $o_article['tout_livre'] = 1;
            }

            /* Montant total */
            $o_article['montant_total'] = 0;
            
            /* On récupère les attributs nécéssaires des articles commandés par 
                * l'utilisateur */
            foreach($to_article as $o_produit){
                $i_idArticle = $o_produit['id_article'];
                $i_quantite = Commande::getQuantiteByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                $i_poidsPaquetClient = ArticleCampagne::getPoidsPaquetClient($i_idArticleCampagne);
                $i_prixTtc = ArticleCampagne::getPrixTtc($i_idArticleCampagne);                
                $i_idPoidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
            /* Calcul quantité totale */
            $i_quantiteTotale = $i_quantite * $i_poidsPaquetClient;
            /* Calcul total TTC */
            $i_totalTtc = $i_quantiteTotale * $i_prixTtc / $i_idPoidsPaquetFournisseur;
            /* Calcul du montant total */
            $o_article['montant_total'] += $i_totalTtc;
            } 
            /* Formattage des nombres */
            $i_quantiteTotale = number_format($i_quantiteTotale, 2, '.', '');
            $i_totalTtc = number_format($i_totalTtc, 2, '.', '');
            $o_article['montant_total'] = number_format($o_article['montant_total'], 2, '.', '');
        } 
        $this->render('utilisateurAyantCommandE', compact('to_commande', 'b_historique', 'i_idCampagne'));	
    }

    /*
     * Affiche la liste des commandes d'un utilisateur pour la campagne 
     * courante.
     */
    public function commandeUtilisateur() {
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
        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* Récupération de l'identifiant de l'utilisateur */
        if (!isset($_GET['idUtilisateur'])) {
            header('Location: '.root.'/utilisateurAyantCommandE.php/utilisateurAyantCommandE');
            return;
        }
        $i_idUtilisateur = $_GET['idUtilisateur'];
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
        }
        // recherche du login 
        $s_login = Utilisateur::getLogin($i_idUtilisateur);
        /* Formattage des nombres */
        $f_montantTotal = number_format($f_montantTotal, 2, '.', '');
        foreach($f_montantParRayon as &$montant_cat){$montant_cat=number_format($montant_cat, 2, '.', '');}
        /* Render */
        $this->render('commandeUtilisateur', compact('to_commande', 'b_etat', 'f_montantTotal', 'i_idUtilisateur', 's_login', 'b_historique', 'i_idCampagne','f_montantParRayon'));	
    }

    /*
     * Gère la modification des quantités dans la commande d'un utilisateur.
     */
    public function modifierQuantiteUtilisateur() {
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
            return;
        }
        $i_idUtilisateur = $_GET['idUtilisateur']; 
        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
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
            /* Modification de est_livre */
            if (isset($_POST['est_livre'])) {
                $tb_estLivre = $_POST['est_livre'];
                if(isset($tb_estLivre[$i_idArticle])){
                    $b_estLivre = $tb_estLivre[$i_idArticle];
                    if ($b_estLivre == 1) {
                        Commande::setEstLivre($i_idCommande, 1);
                    } 
                }
            }
            else {
                Commande::setEstLivre($i_idCommande, 0);
            }

        }
        /* Redirection */
        if ($i_idCampagne == Campagne::getIdCampagneCourante()) {
            header('Location: '.root.'/utilisateurAyantCommandE.php/commandeUtilisateur?idUtilisateur='.$i_idUtilisateur);
        } else {
            header('Location: '.root.'/utilisateurAyantCommandE.php/commandeUtilisateur?idUtilisateur='.$i_idUtilisateur.'&idOldCampagne='.$i_idCampagne);
        }
    }

    /*
     * Supprime l'article d'un utilisateur.
     */
    public function supprimerArticleUtilisateur() {
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
        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        /* Récupération de l'id article à supprimer */
        $i_idArticle = $_GET['id_article'];
        $i_idCommande = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
        Commande::delete($i_idCommande);
        /* Redirection */
        if ($i_idCampagne == Campagne::getIdCampagneCourante()) {
            header('Location: '.root.'/utilisateurAyantCommandE.php/commandeUtilisateur?idUtilisateur='.$i_idUtilisateur);
        } else {
            header('Location: '.root.'/utilisateurAyantCommandE.php/commandeUtilisateur?idUtilisateur='.$i_idUtilisateur.'&idOldCampagne='.$i_idCampagne);
        }
    }
    
    public function exportCSV() {
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
            
            /*Passage à la requête suivante*/
            $j=$j+1;
        }
        
        /*Formatage du fichier*/
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
        $header=array('Produit',/*'Description',*/'Poids paquet fournisseur','Nombre paquet par colis','Prix TTC','Prix TTC unitaire',
            'Poids unit commande client','Quantite min commande','Quantite','Quantite totale commandee',
            'Total TTC');
        
        /* Réglage police, couleurs du fond et de la police et placement du curseur pour les titres colonnes */
        $pdf->SetFont('Arial','B',7);
        $pdf->SetFillColor(96,96,96);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY(2,5);
        
        /* Création des cases contenant le titre des colonnes*/
        for($i=0;$i<sizeof($header);$i++)
                $pdf->cell($i==0?7:3.5,1,$header[$i],1,0,'C',1);
        
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
           
            /* Réglage de la police des couleurs et placement du curseur pour les cases */
            $pdf->SetFillColor(0xdd,0xdd,0xdd);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);
            $pdf->SetXY(2,$pdf->GetY()+1);
            $fond=0;
        
            /* Ecriture dans les différentes cellules */
            $pdf->cell(7,0.7,html_entity_decode($o_article['nom'],ENT_COMPAT,"ISO-8859-1"),1,0,'C',$fond);
            //$pdf->cell(3.5,0.7,$o_article['description_courte'],1,0,'C',$fond);
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

        /*Montant total, concaténation de la chaine de caractère, choix police couleurs et placement curseurs*/
        $Montant_Total="Total : ".$f_montantTotal." Euros";
        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY(37,$pdf->GetY()+1);
        
        /*Ecriture du montant total dans sa case*/
        $pdf->cell(3.5,0.7,$Montant_Total,1,0,'C',$fond);
        
        /*Fin PDF*/
        $pdf->output();
    }
    
    public function exportPDFAll() {
        
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        
        /* Récupération de l'identifiant de la campagne courante */
        $i_idCampagne = $_GET['id_camp'];
        
        /* Récupération de l'état de la campagne */
        $b_etat = Campagne::getEtat($i_idCampagne);
        
        /*Création du PDF*/
        $pdf=new FPDF('L','cm','A3');
        $pdf->Open();
        $pdf->SetTitle("Factures de la campagne ".$i_idCampagne);
        
        /* On récupère un tableau des utilisateurs du site */
        $to_utilisateur=Utilisateur::getAllObjects();
        
        /* Pour chaque utilisateur */
        foreach($to_utilisateur as $i_idUtilisateur){
            
            /* On recupère sa commande */
            $to_commande = Commande::getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur['id']);

            /* Si elle n'est pas nulle, on créé la page PDF et on la remplit*/
            if ($to_commande!=NULL) {
                
                /* Nouvelle page pour nouvelle facture*/
                $pdf->AddPage();
                                
                /*Récupération Nom et Prénom de l'Utilisateur*/
                $userLogin=Utilisateur::getLogin($i_idUtilisateur['id']);
                $userName=Utilisateur::getNom($i_idUtilisateur['id']);
                $userSurname=Utilisateur::getPrenom($i_idUtilisateur['id']);

                $docTitle="Facture de ".$userLogin." ".$userName." ".$userSurname." pour la campagne ".$i_idCampagne;

                /*Titre du document*/
                $pdf->SetFont('Arial','UB',14);
                $pdf->Write(5,$docTitle);

                /*Titres des colonnes*/
                $header=array('Produit',/*'Description',*/'Code fournisseur', 'Poids paquet fournisseur','Nombre paquet par colis','Prix TTC','Prix TTC unitaire',
                'Quantite min commande','Quantite','Quantite totale commandee',
                    'Total TTC');

                /* Réglage police, couleurs du fond et de la police et placement du curseur pour les titres colonnes */
                $pdf->SetFont('Arial','B',7);
                $pdf->SetFillColor(96,96,96);
                $pdf->SetTextColor(255,255,255);
                $pdf->SetXY(2,5);

                /* Création des cases contenant le titre des colonnes*/
                for($i=0;$i<sizeof($header);$i++)
                        $pdf->cell($i==0?7:3.5,1,$header[$i],1,0,'C',1);

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

                    /* Réglage de la police des couleurs et placement du curseur pour les cases */
                    $pdf->SetFillColor(0xdd,0xdd,0xdd);
                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont('Arial','',10);
                    $pdf->SetXY(2,$pdf->GetY()+1);
                    $fond=0;

                    /* Ecriture dans les différentes cellules */
                    $pdf->cell(7,0.7,html_entity_decode($o_article['nom'],ENT_COMPAT,"ISO-8859-1"),1,0,'C',$fond);
                    //$pdf->cell(3.5,0.7,$o_article['description_courte'],1,0,'C',$fond);
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

                /*Montant total, concaténation de la chaine de caractère, choix police couleurs et placement curseurs*/
                $Montant_Total="Total : ".$f_montantTotal." Euros";
                $pdf->SetFont('Arial','B',10);
                $pdf->SetXY(37,$pdf->GetY()+1);

                /*Ecriture du montant total dans sa case*/
                $pdf->cell(3.5,0.7,$Montant_Total,1,0,'C',$fond);
            }
        }
        /*Fin PDF*/
        $pdf->output();
    }
    
    public function etiquettesUtilisateurAll() 
            {
        
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


        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        
        /* On récupère un tableau des utilisateurs du site */
        $to_utilisateur=Utilisateur::getAllObjects();
        
        /*Titre de la page PDF qui se charge, apparait dans le titre de la page Web*/
        $docTitle="Etiquettes de la campagne ".$i_idCampagne;
        
        /*Création du PDF format A4*/
        $pdf=new FPDF('P','cm','A4');
        $pdf->Open();
        $pdf->SetTitle($docTitle);
        
        /*Première page*/
        $pdf->AddPage();
        
        /*Compteurs - Curseurs*/
        $numEtiquette=0; // numéro de l'étiquette
        $Gauche=true; // Position de l'étiquette
        
        /* Pour chaque utilisateur */
        foreach($to_utilisateur as $i_idUtilisateur){
            
            /* On recupère sa commande */
            $to_commande = Commande::getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur['id']);
        
            /* Si elle n'est pas nulle, on créé la page PDF et on la remplit*/
            if ($to_commande!=NULL) {
            
                /*Récupération Nom et Prénom Mail de l'Utilisateur*/
                $userName=Utilisateur::getNom($i_idUtilisateur['id']);
                $userSurname=Utilisateur::getPrenom($i_idUtilisateur['id']);
                $userMail=  Utilisateur::getEmail($i_idUtilisateur['id']);

                /*Titre de la page PDF qui se charge, apparait dans le titre de la page Web*/
                $docTitle="Commande de ".$userSurname." ".$userName." campagne ".$i_idCampagne;

                /* Récupération de tous les attributs nécessaires d'un article */
                foreach($to_commande as &$o_article) {
                    $numEtiquette=$numEtiquette+1;

                    /* Attributs dépendant de l'article */
                    $i_idArticle = $o_article['id_article'];
                    $o_article['nom'] = Article::getNom($i_idArticle);
                    $o_article['description_courte'] = Article::getDescriptionCourte($i_idArticle);
                    $o_article['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
                    /* Prix TTC, seuil min et poids paquet client */
                    $o_article_campagne = ArticleCampagne::getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                    $o_article['poids_paquet_client'] = $o_article_campagne['poids_paquet_client'];

                    /* Calcul quantité totale */
                    $o_article['quantite_totale'] = $o_article['quantite'] * $o_article['poids_paquet_client'];
                    $o_article['quantite_totale'] = number_format($o_article['quantite_totale'], 2, '.', '');

                    /* 
                     * Si la quantité totale commandée n'est pas un multiple du poids_paquet_fournisseur créé pas l'étiquette 
                     * On imprime une étiquette que si l'on sépare un paquet fournisseur en plusieurs paquets utilisateurs 
                     * La multiplication et divison par 1000 évitent les problèmes de "division par zéro" considéré dès que le poids paquet fournisseur vaut 0.XXX            
                     */

                    if(fmod($o_article['quantite_totale'],$o_article['poids_paquet_fournisseur']) !=0){
                
                        /* 
                         * Si l'utilisateur ne commande pas un multiple exacte du produit, on n'imprime cependant des étiquettes que pour les
                         * surplus. On prend le modulo pour calculer la quantite totale qu'on impose à l'étiquette.
                         */    

                        $o_article['quantite_totale_mod']=fmod($o_article['quantite_totale'],$o_article['poids_paquet_fournisseur']);


                        /* Le format impose 24 étiquettes par page max */

                        if($numEtiquette==25) {
                            $pdf->AddPage();
                            $numEtiquette=1;
                        }

                        /*Réglage police, écriture du titre, placement du curseur si étiquette est à gauche ou droite */
                        $pdf->SetFont('Arial','',12);
                        if($Gauche){
                            $pdf->SetX(1);
                        }else{
                            $pdf->SetX(11);
                        }
                        $pdf->Write(1,$userName." ".$userSurname);
                        if($Gauche){
                            $pdf->SetX(1);
                        }else{
                            $pdf->SetX(11);
                        }

                        /* Réglage de la police et des couleurs, placement des curseurs*/
                        $pdf->SetFillColor(0xdd,0xdd,0xdd);
                        $pdf->SetTextColor(0,0,0);
                        $pdf->SetFont('Arial','',8);
                        if($Gauche){
                            $pdf->SetXY(1,$pdf->GetY()+1);
                        }else{
                            $pdf->SetXY(11,$pdf->GetY()+1);
                        }

                        $fond=0;

                        /*Ecriture du contenu des cellules : nom description et quantité totale (kg)*/
                        $pdf->cell(3,0.7,$o_article['nom'],1,0,'C',$fond);
                        $pdf->cell(3,0.7,$o_article['description_courte'],1,0,'C',$fond);
                        $pdf->cell(3,0.7,$o_article['quantite_totale_mod']." (total ".$o_article['quantite_totale'].")",1,0,'C',$fond);
                        $fond=!$fond;

                        /* 
                         * Il faut mettre une étiquette à gauche une à droite, et les unes en dessous des autres
                         * Voici le réglage :
                         * 
                         * Si c'est à gauche, on passe les curseurs à droite pour la prochaine étiquette
                         * 
                         * Si c'est à droite, on passe le curseur à gauche et en dessous pour la prochaine étiquette
                         * 
                         */

                        if ($Gauche==true){
                            $pdf->SetXY(11, $pdf->GetY()-1);
                            $Gauche=false;
                        }
                        else {
                            $pdf->SetXY(1, $pdf->GetY()+1);
                            $Gauche=true;
                        }
                    }
                }
            }
        }
        /*Fin du PDF quand on a passé en revu toutes les étiquettes*/
        $pdf->output();
        
    }
    
    public function etiquettesUtilisateur() {
        
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

        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        
        /*Récupération Nom et Prénom Mail de l'Utilisateur*/
        $userName=Utilisateur::getNom($i_idUtilisateur);
        $userSurname=Utilisateur::getPrenom($i_idUtilisateur);
        $userMail=  Utilisateur::getEmail($i_idUtilisateur);
        
        /*Titre de la page PDF qui se charge, apparait dans le titre de la page Web*/
        $docTitle="Commande de ".$userSurname." ".$userName." campagne ".$i_idCampagne;
        
        /*Création du PDF format "etiquette" spécialement créé pour le projet dans FPDF.php*/
        $pdf=new FPDF('L','cm','etiquette');
        $pdf->Open();
        $pdf->SetTitle($docTitle);
        
        /* On recupère la commande d'un utilisateur */
        $to_commande = Commande::getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);
        
        /* Récupération de tous les attributs nécessaires d'un article */
        foreach($to_commande as &$o_article) {
            /* Attributs dépendant de l'article */
            $i_idArticle = $o_article['id_article'];
            $o_article['nom'] = Article::getNom($i_idArticle);
            $o_article['description_courte'] = Article::getDescriptionCourte($i_idArticle);
            $o_article['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
            /* Prix TTC, seuil min et poids paquet client */
            $o_article_campagne = ArticleCampagne::getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $o_article['poids_paquet_client'] = $o_article_campagne['poids_paquet_client'];
            
            /* Calcul quantité totale */
            $o_article['quantite_totale'] = $o_article['quantite'] * $o_article['poids_paquet_client'];
            
            /* 
             * Si la quantité totale commandée n'est pas un multiple du poids_paquet_fournisseur créé pas l'étiquette 
             * On imprime une étiquette que si l'on sépare un paquet fournisseur en plusieurs paquets utilisateurs 
             * La multiplication et divison par 1000 évitent les problèmes de "division par zéro" considéré dès que le poids paquet fournisseur vaut 0.XXX            
             */
            
            if(fmod($o_article['quantite_totale'],$o_article['poids_paquet_fournisseur']) !=0){
                
                /* 
                 * Si l'utilisateur ne commande pas un multiple exacte du produit, on n'imprime cependant des étiquettes que pour les
                 * surplus. On prend le modulo pour calculer la quantite totale qu'on impose à l'étiquette.
                 */    
                
                $o_article['quantite_totale_mod']=fmod($o_article['quantite_totale'],$o_article['poids_paquet_fournisseur']);
                            
            
                /*Choix police, placement du curseur, écriture du num campagne, nom, prenom*/
                $pdf->AddPage();
                $pdf->SetFont('Arial','',12);
                $pdf->Write(1,$userName." ".$userSurname);

                /* Réglage police, placement curseur*/
                $pdf->SetFillColor(0xdd,0xdd,0xdd);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial','',8);
                $pdf->SetXY(1,$pdf->GetY()+1);
                $fond=0;

                /* Ecriture dans les cellules */
                $pdf->cell(4,0.7,$o_article['nom'],1,0,'C',$fond);
                $pdf->cell(4,0.7,$o_article['description_courte'],1,0,'C',$fond);
                $pdf->cell(4,0.7,$o_article['quantite_totale_mod']." (total ".$o_article['quantite_totale'].")",1,0,'C',$fond);
                $pdf->SetXY(1,$pdf->GetY()+0);
                $fond=!$fond;
            
            }
        }
       
        /*Fin PDF*/
        $pdf->output();
    }
    
    public function etiquettesUtilisateurPage() {
        
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

        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        /*Récupération Nom et Prénom Mail de l'Utilisateur*/
        $userName=Utilisateur::getNom($i_idUtilisateur);
        $userSurname=Utilisateur::getPrenom($i_idUtilisateur);
        $userMail=  Utilisateur::getEmail($i_idUtilisateur);
        
        /*Titre de la page PDF qui se charge, apparait dans le titre de la page Web*/
        $docTitle="Commande de ".$userSurname." ".$userName." campagne ".$i_idCampagne;
        
        /*Création du PDF format A4*/
        $pdf=new FPDF('P','cm','A4');
        $pdf->Open();
        $pdf->SetTitle($docTitle);
        
        /* On recupère la commande d'un utilisateur */
        $to_commande = Commande::getObjectsByIdCampagneIdUtilisateur($i_idCampagne, $i_idUtilisateur);
        
        /*Compteurs - Curseurs*/
        $numEtiquette=0; // numéro de l'étiquette sur une page
        $Gauche=true; // Position de l'étiquette
        
        /*Première page*/
        $pdf->AddPage();
        
        /* Récupération de tous les attributs nécessaires d'un article */
        foreach($to_commande as &$o_article) {
            $numEtiquette=$numEtiquette+1;
        
            /* Attributs dépendant de l'article */
            $i_idArticle = $o_article['id_article'];
            $o_article['nom'] = Article::getNom($i_idArticle);
            $o_article['description_courte'] = Article::getDescriptionCourte($i_idArticle);
            $o_article['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
            /* Prix TTC, seuil min et poids paquet client */
            $o_article_campagne = ArticleCampagne::getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $o_article['poids_paquet_client'] = $o_article_campagne['poids_paquet_client'];
            
            /* Calcul quantité totale */
            $o_article['quantite_totale'] = $o_article['quantite'] * $o_article['poids_paquet_client'];
            $o_article['quantite_totale'] = number_format($o_article['quantite_totale'], 2, '.', '');

            /* 
             * Si la quantité totale commandée n'est pas un multiple du poids_paquet_fournisseur créé pas l'étiquette 
             * On n'imprime une étiquette que si l'on sépare un paquet fournisseur en plusieurs paquets utilisateurs 
             * fmod = float modulo. 
             */
            
            if(fmod($o_article['quantite_totale'],$o_article['poids_paquet_fournisseur']) !=0){
                
                /* 
                 * Si l'utilisateur ne commande pas un multiple exacte du produit, on n'imprime cependant des étiquettes que pour les
                 * surplus. On prend le modulo pour calculer la quantite totale qu'on impose à l'étiquette.
                 */    
                
                $o_article['quantite_totale_mod']=fmod($o_article['quantite_totale'],$o_article['poids_paquet_fournisseur']);
                
                /* Le format impose 24 étiquettes par page max */

                if($numEtiquette==25) {
                    $pdf->AddPage();
                    $numEtiquette=1;
                }

                /*Réglage police, écriture du titre, placement du curseur si étiquette est à gauche ou droite */
                $pdf->SetFont('Arial','',12);
                if($Gauche){
                    $pdf->SetX(1);
                }else{
                    $pdf->SetX(11);
                }
                $pdf->Write(1,$userName." ".$userSurname);
                if($Gauche){
                    $pdf->SetX(1);
                }else{
                    $pdf->SetX(11);
                }

                /* Réglage de la police et des couleurs, placement des curseurs*/
                $pdf->SetFillColor(0xdd,0xdd,0xdd);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial','',8);
                if($Gauche){
                    $pdf->SetXY(1,$pdf->GetY()+1);
                }else{
                    $pdf->SetXY(11,$pdf->GetY()+1);
                }

                $fond=0;

                /*Ecriture du contenu des cellules : nom description et quantité totale (kg)*/
                $pdf->cell(3,0.7,$o_article['nom'],1,0,'C',$fond);
                $pdf->cell(3,0.7,$o_article['description_courte'],1,0,'C',$fond);
                $pdf->cell(3,0.7,$o_article['quantite_totale_mod']." (total ".$o_article['quantite_totale'].")",1,0,'C',$fond);
                $fond=!$fond;

                /* 
                 * Il faut mettre une étiquette à gauche une à droite, et les unes en dessous des autres
                 * Voici le réglage :
                 * 
                 * Si c'est à gauche, on passe les curseurs à droite pour la prochaine étiquette
                 * 
                 * Si c'est à droite, on passe le curseur à gauche et en dessous pour la prochaine étiquette
                 * 
                 */

                if ($Gauche==true){
                    $pdf->SetXY(11, $pdf->GetY()-1);
                    $Gauche=false;
                }
                else {
                    $pdf->SetXY(1, $pdf->GetY()+1);
                    $Gauche=true;
                }
            }
        }
        /*Fin du PDF quand on a passé en revu toutes les étiquettes*/
        $pdf->output();
    }
    
    /*
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/utilisateurAyantCommandE.php/mesCommandes');
    }
}
new UtilisateurAyantCommandEController();
?>
