<?php
require_once("Model/Administrateur.php");
require_once("Model/Utilisateur.php");
require_once("Model/Campagne.php");
?>
<div id="menu">
    <?php
    if (Utilisateur::isLogged()) {
        ?>
        <?php
        $bonjour = $_SESSION['login'];
        if (Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
            $bonjour .= " (admin)";
        }
        ?>
        <!-- Commun à tous les utilisateurs -->
        <span id="bonjour">Bonjour <?php echo $bonjour ?>,</span>
        <ul>
            <li><a href="<?php echo root ?>/accueil.php/accueil">Accueil</a></li>
            <li><a href="<?php echo root ?>/connexion.php/deconnexion">Se déconnecter</a></li>
        </ul>
        <!-- Menu administrateur -->
        <h2 class="titre_menu">Campagne n°<?php echo Campagne::getIdCampagneCourante() ?></h2>
        <ul>
            <?php
            if (Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
                ?>
                <li><a href="<?php echo root ?>/campagne.php/gererCampagne">Gestion des campagnes</a></li>
                <li><a href="<?php echo root ?>/utilisateurAyantCommandE.php/utilisateurAyantCommandE">Utilisateurs ayant commandés</a></li>
                <li><a href="<?php echo root ?>/fournisseur.php/fournisseursChoisis">Commandes par fournisseur</a></li>
                <?php
            }
            ?>
            <li><a href="<?php echo root ?>/articlesCommandEs.php/articlesCommandEs">Articles commandés</a></li>
            <li><a href="<?php echo root ?>/utilisateur.php/envoiMailAAdministrateur">Contacter les administrateurs</a></li>
            <?php
            if (!Administrateur::isAdministrateur($_SESSION['idUtilisateur'])){
                ?>
                <li><a href="<?php echo root ?>/campagne.php/historiqueCampagne">Historique des commandes</a></li>
                   <?php
            }
            ?>
        </ul>
        <?php
        if (Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
            ?>

            <h2 class="titre_menu">Administration</h2>
            <ul>
                <li><a href="<?php echo root ?>/article.php/afficherArticle">Gestion des articles</a></li>
                <li><a href="<?php echo root ?>/rayon.php/afficherRayon">Gestion des rayons & des catégories</a></li>
                <li><a href="<?php echo root ?>/tva.php/gererTva">Gestion de la TVA</a></li>
                <li><a href="<?php echo root ?>/fournisseur.php/gererFournisseur">Gestion des fournisseurs</a></li>
                <li><a href="<?php echo root ?>/utilisateur.php/listeUtilisateurAValider">Inscriptions à valider (<?php echo Utilisateur::getCountByValidite(0) ?>)</a></li>
                <li><a href="<?php echo root ?>/utilisateur.php/listeUtilisateurADesinscrire">Désinscriptions à valider (<?php echo Utilisateur::getCountByDesinscrit() ?>)</a></li>
                <li><a href="<?php echo root ?>/utilisateur.php/listeUtilisateurValide">Gestion des utilisateurs</a></li>
                <li><a href="<?php echo root ?>/utilisateur.php/envoiMail">Contacter les utilisateurs</a></li>
                <li><a href="<?php echo root ?>/exportImport.php/listeExport">Exporter les données</a></li>
            </ul>
            <?php
        }
        ?>
        <!-- Menu utilisateur -->
        <h2 class="titre_menu">Menu</h2>
        <ul>
            <li><a href="<?php echo root ?>/mesCommandes.php/mesCommandes">Mes commandes</a></li>
            <li><a href="<?php echo root ?>/commanderArticle.php/afficherRayon">Commander des articles</a></li>
            <li><a href="<?php echo root ?>/utilisateur.php/profil">Mon profil</a></li>
            <?php if(!Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) 
                {
            ?>
            <li><a href="<?php echo root ?>/inscription.php/desinscription">Me désinscrire</a></li>
                <?php }
                ?>
        </ul>
        <?php
    } else {
        ?>
        <ul>
            <li><a href="<?php echo root ?>/index.php">Accueil</a></li>            
        </ul>
        <?php
    }
    ?>

</div><!-- id="menu" -->
