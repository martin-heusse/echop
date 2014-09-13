<?php
require_once('def.php');
require_once ('Util.php');
require_once('FPDF/fpdf.php');
require_once('Model/Export.php');
require_once('Model/Administrateur.php');
require_once('Model/Utilisateur.php');
require_once('Model/Fournisseur.php');
require_once('Model/Campagne.php');
require_once('Model/Commande.php');
require_once('Model/ArticleCampagne.php');
require_once('Model/Article.php');
require_once('Model/ArticleFournisseur.php');
require_once('Model/Unite.php');

/*
 * Gère les fournisseurs.
 */
class FournisseurController extends Controller {

    /*
     * Constructeur.
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Affiche la liste de tous les fournisseurs.
     */
    public function tousLesFournisseurs() {
        /* Authentication required */
        if (!Utilisateur::isLogged()) {
            $this->render('authenticationRequired');
            return;
        }
        /* Doit être un administrateur */
        if(!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }
        /* Récupère tous les fournisseurs */
        $to_fournisseur = Fournisseur::getAllObjects();
        $this->render('tousLesFournisseurs', compact('to_fournisseur'));
    }

    /*
     * Affiche la liste des fournisseurs choisis pour la campagne courante.
     */
    public function fournisseursChoisis() {
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
        /* on récupère l'ensemble des fournisseurs choisis pour la campagne 
         * donnée */
        $to_fournisseur = ArticleCampagne::getIdFournisseurByIdCampagne($i_idCampagne);
        
        /* Pour chaque fournisseur on va chercher les infos nécéssaires pour 
         * connaitre la somme due au fournisseur */
        foreach ($to_fournisseur as &$o_fournisseur) {
            /* Informations concernant chaque fournisseur */
            $i_idFournisseur = $o_fournisseur['id_fournisseur'];
            $o_fournisseur['id'] = $i_idFournisseur;
            $o_fournisseur['nom'] = Fournisseur::getNom($i_idFournisseur);
            $to_articleFournisseur = ArticleCampagne::getObjectsByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur);
            $f_montantTtc = 0;
            /* pour un fournisseur donné, on récupère tous les articles 
             * commandés*/
            foreach ($to_articleFournisseur as &$o_articleFournisseur) {
                /* pour chaque article, on récupère les données qui vont nous 
                 * permettre de calculer le prix d'achat au fournisseur */
                $i_quantiteTotaleArticle = 0;
                $i_idArticle = $o_articleFournisseur['id_article'];
                $f_poidsPaquetClient = $o_articleFournisseur['poids_paquet_client'];
                $ti_idUtilisateur = Commande::getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                /* pour chaque utilisateur, on regarde combien il a commandé */
                foreach ($ti_idUtilisateur as $i_idUtilisateur) {
                    $i_id = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                    $i_quantite = Commande::getQuantite($i_id);
                    $i_quantiteTotaleArticle += $i_quantite;
                }
                /* On calcule la quantité totale commandée selon l'unité */
                $i_quantiteTotaleArticleReelle = $i_quantiteTotaleArticle * $f_poidsPaquetClient;
                /* on cherche le prix du paquet fournisseur*/
                $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                $f_prixTtcArticle = ArticleFournisseur::getPrixTtcByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
                $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
                if($i_poidsPaquetFournisseur==0)
                  $i_poidsPaquetFournisseur=1;
                $f_prixTotaleArticle = $i_quantiteTotaleArticleReelle * $f_prixTtcArticle / $i_poidsPaquetFournisseur;
                $f_montantTtc += $f_prixTotaleArticle;
            }
            /* Montant du aux fournisseurs */
            $o_fournisseur['montant_total'] = $f_montantTtc;
            /* Formattage des nombres */
            $o_fournisseur['montant_total'] = number_format($o_fournisseur['montant_total'], 2, '.', ' ');
        }
        $this->render('fournisseursChoisis', compact('to_fournisseur', 'b_historique', 'i_idCampagne'));
    }

    /*
     * Affiche la liste des articles commandés auprès d'un fournisseur pour la 
     * campagne courante.
     */
    public function commandeFournisseur() {
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
        /* On récupère l'identifiant du fournisseur */
        if(!isset($_GET['idFournisseur'])) {
            header('Location: '.root.'/articleCampagne.php/fournisseursChoisis');
            return;
        }
        $i_idFournisseur = $_GET['idFournisseur'];
        /* On récupère les articles qui vont être acheté aux fournisseurs */
        $to_article = ArticleCampagne::getObjectsByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur);
        /* On regarde le nombre d'article commandés à ce fournisseur */
            $i_nbreArticle = 0;
        foreach ($to_article as &$o_article) {
            /* pour chaque article, on récupère les données qui vont nous 
             * permettre de connaître la quantité totale et le prix */
            $i_quantiteTotale = 0;
            $i_idArticle = $o_article['id_article'];
            $f_poidsPaquetClient = $o_article['poids_paquet_client'];
            $ti_idUtilisateur = Commande::getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            /* pour chaque utilisateur, on regarde combien il a commandé*/
            foreach ($ti_idUtilisateur as $i_idUtilisateur) {
                $i_nbreArticle++;
                $i_id = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                $i_quantite = Commande::getQuantite($i_id);
                $i_quantiteTotale += $i_quantite;
            }
            $o_article['quantite_totale'] = $i_quantiteTotale * $f_poidsPaquetClient;
            $o_article['quantite_totale_unites'] = $i_quantiteTotale;
            /* on calcule le prix du paquet fournisseur*/
            $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $f_prixTtcArticle = ArticleFournisseur::getPrixTtcByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
            $o_article['montant_total'] = $o_article['quantite_totale'] * $f_prixTtcArticle / $i_poidsPaquetFournisseur;
            $o_article['nom'] = Article::getNom($i_idArticle);
            $i_idUnite = Article::getIdUnite($i_idArticle);
            $o_article['unite'] = Unite::getValeur($i_idUnite);
            
            
            /* Récupération du Code Fournisseur, 1&2 cahier des charges */
            //$i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idFournisseur = ArticleCampagne::getIdFournisseur($i_idArticleCampagne);
            //$o_article_fournisseur = ArticleFournisseur::getObjectByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $i_idArticleFournisseur = ArticleFournisseur::getIdByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $o_article['code'] = ArticleFournisseur::getCode($i_idArticleFournisseur);
            $o_article['nom_fournisseur'] = Fournisseur::getNom($i_idFournisseur);
            
            /* Calcul du prix unitaire 1&2 cahier des charges */
            $o_article_campagne = ArticleCampagne::getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idArticleFournisseur = ArticleFournisseur::getIdByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $o_article['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
            $o_article['prix_ttc'] = $o_article_campagne['prix_ttc'];
            $o_article['seuil_min'] = $o_article_campagne['seuil_min'];
            $o_article['poids_paquet_client'] = $o_article_campagne['poids_paquet_client'];
            /* Valeurs calculées */
            /* Calcul poids unitaire */
            $o_article['prix_unitaire'] = $o_article['prix_ttc'] / $o_article['poids_paquet_fournisseur'];
            $o_article['prix_unitaire_client'] = $o_article['prix_unitaire'] * $o_article['poids_paquet_client'];
            
            $o_article['prix_unitaire_client'] = number_format($o_article['prix_unitaire_client'], 2, '.', '');
            $o_article['prix_unitaire'] = number_format($o_article['prix_unitaire'], 2, '.', '');
            $o_article['montant_total'] = number_format($o_article['montant_total'], 2, '.', '');
            $o_article['prix_ht'] = ArticleFournisseur::getPrixHt($i_idArticleFournisseur);
            $o_article['prix_ttc'] = ArticleFournisseur::getPrixTtc($i_idArticleFournisseur);
            $o_article['prix_ttc_ht'] = ArticleFournisseur::getPrixTtcHt($i_idArticleFournisseur);
            $o_article['vente_paquet_unite'] = ArticleFournisseur::getVentePaquetUnite($i_idArticleFournisseur);

            // Récupération de la somme totale de la commande pour le fournisseur
            
            $to_articleFournisseur = ArticleCampagne::getObjectsByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur);
            $f_montantTtc = 0;
            /* pour un fournisseur donné, on récupère tous les articles 
             * commandés*/
            foreach ($to_articleFournisseur as &$o_articleFournisseur) {
                /* pour chaque article, on récupère les données qui vont nous 
                 * permettre de calculer le prix d'achat au fournisseur */
                $i_quantiteTotaleArticle = 0;
                $i_idArticle = $o_articleFournisseur['id_article'];
                $f_poidsPaquetClient = $o_articleFournisseur['poids_paquet_client'];
                $ti_idUtilisateur = Commande::getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                /* pour chaque utilisateur, on regarde combien il a commandé */
                foreach ($ti_idUtilisateur as $i_idUtilisateur) {
                    $i_id = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                    $i_quantite = Commande::getQuantite($i_id);
                    $i_quantiteTotaleArticle += $i_quantite;
                }
                /* On calcule la quantité totale commandée selon l'unité */
                $i_quantiteTotaleArticleReelle = $i_quantiteTotaleArticle * $f_poidsPaquetClient;
                /* on cherche le prix du paquet fournisseur*/
                $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
                $f_prixTtcArticle = ArticleFournisseur::getPrixTtcByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
                $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
                $f_prixTotaleArticle = $i_quantiteTotaleArticleReelle * $f_prixTtcArticle / $i_poidsPaquetFournisseur;
                $f_montantTtc += $f_prixTotaleArticle;
            }
            /* Montant du aux fournisseurs */
            $o_fournisseur['montant_total'] = $f_montantTtc;
            /* Formattage des nombres */
            $o_fournisseur['montant_total'] = number_format($o_fournisseur['montant_total'], 2, '.', ' ');
            $f_montantTtc=$o_fournisseur['montant_total'];
        
            
        }
        $this->render('commandeFournisseur', compact('f_montantTtc', 'to_article', 'i_nbreArticle', 'b_historique', 'i_idCampagne', 'i_idFournisseur'));
    }

    /*
     *  Gère les fournisseurs
     */
    public function gererFournisseur() {

        /* On récupère le nom du fournisseur tapé par l'utilisateur */
        if (isset($_POST['nom_fournisseur']) && $_POST['nom_fournisseur'] != "") {
            $s_nom = $_POST['nom_fournisseur'];

            /* Vérification de la pré-existence: on interdit que le nom n'existe 
                * pas déjà */
            $o_fournisseur = Fournisseur::getObjectByNom($s_nom);
            if ($o_fournisseur == array()) {
                Fournisseur::create($s_nom);
            }
        }
        /* On récupère le nom de tous les fournisseurs pour les afficher */
            $to_nom = Fournisseur::GetAllObjects();
            $this->render('gererFournisseur', compact('to_nom'));
            return;
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
        
        /* On récupère l'identifiant du fournisseur */
        if(!isset($_GET['idFournisseur'])) {
            header('Location: '.root.'/articleCampagne.php/fournisseursChoisis');
            return;
        }
        $i_idFournisseur = $_GET['idFournisseur'];
        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        
        /*Récupération nom Fournisseur*/
        $fournisseurName=Fournisseur::getNom($i_idFournisseur);
        
        // Nom BD
        $database="BdEchoppe";
        
        // Connexion BD
        Export::connect();

        // la variable qui va contenir les données CSV
        $outputCsv = '';

        // Nom du fichier qu'on initialise puis qu'on attribue
        $fileName = "Commande_fournisseur_".$fournisseurName."_campagne".$i_idCampagne.".csv";
        
        // Deux requêtes : une qui exporte les données de la commande, l'autre le total TTC
        $j=0;
        while($j<2){
            if($j == 0)
                {
                    $requete = Commande::getExportCSVFournisseur($i_idFournisseur, $i_idCampagne);
                }else{
                    $requete= Commande::getExportCSVTotalTTCFournisseur($i_idFournisseur, $i_idCampagne);
                }
            
            // Ecriture dans la variable CSV de la requête (voir le système CSV)
            $outputCsv=Export::exportExcel($requete, $outputCsv);
            
            //Passage à la reqûete suivante
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
        /* Doit être un administrateur */
        if (!$_SESSION['isAdministrateur']) {
            $this->render('adminRequired');
            return;
        }

        /* On récupère l'identifiant du fournisseur */
        if(!isset($_GET['idFournisseur'])) {
            header('Location: '.root.'/articleCampagne.php/fournisseursChoisis');
            return;
        }
        $i_idFournisseur = $_GET['idFournisseur'];
        /* Navigation dans l'historique ou non */
        $b_historique = 0;
        if (isset($_GET['idOldCampagne'])) {
            $i_idCampagne = $_GET['idOldCampagne'];
            $b_historique = 1;
        } else {
            $i_idCampagne = Campagne::getIdCampagneCourante();
        }
        
        /*Nom Fournisseur*/
        $nomFournisseur=Fournisseur::getNom($i_idFournisseur);
        
        /*Titre de la page PDF qui se charge, apparait dans le titre de la page Web*/
        $docTitle="Recapitulatif de commande du fournisseur ".$nomFournisseur." pour la campagne ".$i_idCampagne;
        
        /*Création du PDF*/
        $pdf=new FPDF('P','cm','A4');
        $pdf->Open();
        $pdf->SetTitle($docTitle);
        
        /*Titre du document*/
        $pdf->SetFont('Arial','UB',14);
        $pdf->AddPage();
        $pdf->Write(5,$docTitle);
        
        /*Titres des colonnes*/
        $header=array('Code Fournisseur','Article','Quantité','Prix unitaire','Prix Total');
        
        /* Réglage police, couleurs du fond et de la police et placement du curseur pour les titres colonnes */
        $pdf->SetFont('Arial','B',6);
        $pdf->SetFillColor(96,96,96);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY(2,5);
        
        /* Création des cases contenant le titre des colonnes*/
        for($i=0;$i<sizeof($header);$i++)
                $pdf->cell(3.5,1,$header[$i],1,0,'C',1);
        
        /* Montant total */
        $f_montantTotal = 0;
        $f_montantParRayon = NULL;
        
        /* Récupération de tous les attributs commandés à la campagne auprès d'un fournisseur */
        $to_article = ArticleCampagne::getObjectsCommandByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur);
        /* On regarde le nombre d'article commandés à ce fournisseur */
            $i_nbreArticle = 0;
        foreach ($to_article as &$o_article) {
            /* pour chaque article, on récupère les données qui vont nous 
             * permettre de connaître la quantité totale et le prix */
            $i_quantiteTotale = 0;
            $i_idArticle = $o_article['id_article'];
            $f_poidsPaquetClient = $o_article['poids_paquet_client'];
            $ti_idUtilisateur = Commande::getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            /* pour chaque utilisateur, on regarde combien il a commandé*/
            foreach ($ti_idUtilisateur as $i_idUtilisateur) {
                $i_nbreArticle++;
                $i_id = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                $i_quantite = Commande::getQuantite($i_id);
                $i_quantiteTotale += $i_quantite;
            }
            $o_article['quantite_totale'] = $i_quantiteTotale * $f_poidsPaquetClient;
            $o_article['quantite_totale_unites'] = $i_quantiteTotale;
            /* on calcule le prix du paquet fournisseur*/
            $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $f_prixTtcArticle = ArticleFournisseur::getPrixTtcByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
            $o_article['montant_total'] = $o_article['quantite_totale'] * $f_prixTtcArticle / $i_poidsPaquetFournisseur;
            $o_article['nom'] = Article::getNom($i_idArticle);
            $i_idUnite = Article::getIdUnite($i_idArticle);
            $o_article['unite'] = Unite::getValeur($i_idUnite);
            
            
            /* Récupération du Code Fournisseur*/
            //$i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idFournisseur = ArticleCampagne::getIdFournisseur($i_idArticleCampagne);
            //$o_article_fournisseur = ArticleFournisseur::getObjectByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $i_idArticleFournisseur = ArticleFournisseur::getIdByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $o_article['code'] = ArticleFournisseur::getCode($i_idArticleFournisseur);
            $o_article['nom_fournisseur'] = Fournisseur::getNom($i_idFournisseur);
            
            /* Calcul du prix unitaire*/
            $o_article_campagne = ArticleCampagne::getObjectByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $i_idArticleFournisseur = ArticleFournisseur::getIdByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $o_article['poids_paquet_fournisseur'] = Article::getPoidsPaquetFournisseur($i_idArticle);
            $o_article['prix_ttc'] = $o_article_campagne['prix_ttc'];
            $o_article['seuil_min'] = $o_article_campagne['seuil_min'];
            $o_article['poids_paquet_client'] = $o_article_campagne['poids_paquet_client'];
            /* Valeurs calculées */
            /* Calcul poids unitaire */
            $o_article['prix_unitaire'] = $o_article['prix_ttc'] / $o_article['poids_paquet_fournisseur'];
            $o_article['prix_unitaire_client'] = $o_article['prix_unitaire'] * $o_article['poids_paquet_client'];
            
            $o_article['prix_unitaire_client'] = number_format($o_article['prix_unitaire_client'], 2, '.', '');
            $o_article['prix_unitaire'] = number_format($o_article['prix_unitaire'], 2, '.', '');
            $o_article['montant_total'] = number_format($o_article['montant_total'], 2, '.', '');
            $o_article['prix_ht'] = ArticleFournisseur::getPrixHt($i_idArticleFournisseur);
            $o_article['prix_ttc'] = ArticleFournisseur::getPrixTtc($i_idArticleFournisseur);
            $o_article['prix_ttc_ht'] = ArticleFournisseur::getPrixTtcHt($i_idArticleFournisseur);
            $o_article['vente_paquet_unite'] = ArticleFournisseur::getVentePaquetUnite($i_idArticleFournisseur);

            /* Réglage de la police des couleurs et placement du curseur pour les cases */
            $pdf->SetFillColor(0xdd,0xdd,0xdd);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',6);
            $pdf->SetXY(2,$pdf->GetY()+1);
            $fond=0;
        
            // Prix HT ou TTC    
            if ($o_article['prix_ttc_ht']) {$prix=$o_article['prix_ht'];}
                                        else {$prix=$o_article['prix_ttc'];}
                                          
            // Affichage unité ou paquet
            if ($o_article['vente_paquet_unite']) {$paq_unit="paquet";}
                                        else {$paq_unit=$o_article['unite'];}
            // Afficahge HT ou TTC
            if ($o_article['prix_ttc_ht']) {$ht_ttc="HT";}
                                        else {$ht_ttc="TTC";}
            
            /* Ecriture dans les différentes cellules */
            $pdf->cell(3.5,0.7,$o_article['code'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['nom'],1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['quantite_totale'].$o_article['unite'].$o_article['quantite_totale_unites']." (".$o_article['quantite_totale_unites']." unites)",1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$prix." euros/".$paq_unit.$ht_ttc,1,0,'C',$fond);
            $pdf->cell(3.5,0.7,$o_article['montant_total'],1,0,'C',$fond);
            $pdf->SetXY(2,$pdf->GetY()+0);
            $fond=!$fond;
        }

        // Récupération de la somme totale de la commande pour le fournisseur

        $to_articleFournisseur = ArticleCampagne::getObjectsByIdCampagneIdFournisseur($i_idCampagne, $i_idFournisseur);
        $f_montantTtc = 0;
        /* pour un fournisseur donné, on récupère tous les articles 
         * commandés*/
        foreach ($to_articleFournisseur as &$o_articleFournisseur) {
            /* pour chaque article, on récupère les données qui vont nous 
             * permettre de calculer le prix d'achat au fournisseur */
            $i_quantiteTotaleArticle = 0;
            $i_idArticle = $o_articleFournisseur['id_article'];
            $f_poidsPaquetClient = $o_articleFournisseur['poids_paquet_client'];
            $ti_idUtilisateur = Commande::getIdUtilisateurByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            /* pour chaque utilisateur, on regarde combien il a commandé */
            foreach ($ti_idUtilisateur as $i_idUtilisateur) {
                $i_id = Commande::getIdByIdArticleIdCampagneIdUtilisateur($i_idArticle, $i_idCampagne, $i_idUtilisateur);
                $i_quantite = Commande::getQuantite($i_id);
                $i_quantiteTotaleArticle += $i_quantite;
            }
            /* On calcule la quantité totale commandée selon l'unité */
            $i_quantiteTotaleArticleReelle = $i_quantiteTotaleArticle * $f_poidsPaquetClient;
            /* on cherche le prix du paquet fournisseur*/
            $i_idArticleCampagne = ArticleCampagne::getIdByIdArticleIdCampagne($i_idArticle, $i_idCampagne);
            $f_prixTtcArticle = ArticleFournisseur::getPrixTtcByIdArticleCampagneIdFournisseur($i_idArticleCampagne, $i_idFournisseur);
            $i_poidsPaquetFournisseur = Article::getPoidsPaquetFournisseur($i_idArticle);
            $f_prixTotaleArticle = $i_quantiteTotaleArticleReelle * $f_prixTtcArticle / $i_poidsPaquetFournisseur;
            $f_montantTtc += $f_prixTotaleArticle;
        }
        /* Montant du aux fournisseurs */
        $o_fournisseur['montant_total'] = $f_montantTtc;
        /* Formattage des nombres */
        $o_fournisseur['montant_total'] = number_format($o_fournisseur['montant_total'], 2, '.', ' ');
        $f_montantTtc=$o_fournisseur['montant_total'];
        
        /*Montant total, concaténation de la chaine de caractère, choix police couleurs et placement curseurs*/
        $Montant_Total="Total : ".$f_montantTtc." Euros";
        $pdf->SetFont('Arial','B',8);
        $pdf->SetXY(16,$pdf->GetY()+1);
        
        /*Ecriture du montant total dans sa case*/
        $pdf->cell(3.5,0.7,$Montant_Total,1,0,'C',$fond);
        
        /*Fin du PDF*/
        $pdf->output();
    }
    
    /*
     * Action par défaut.
     */
    public function defaultAction() {
        header('Location: '.root.'/fournisseur.php/tousLesFournisseurs');
    }
}
new FournisseurController();
?>
