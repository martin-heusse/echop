<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Gérer les campagnes</h1>

<p>Les utilisateurs peuvent commander des articles tant que la campagne est ouverte.<br/>
Vous pouvez à tout moment bloquer les commandes ou les ré-ouvrir.<br/>
Démarrer une nouvelle campagne archive la campagne en cours et en démarre une nouvelle.</p>

<h2>Nouvelle campagne</h2>

<?php
if ($o_campagne['etat'] == 1) {
?>
<p><strong>Pour démarrer une nouvelle campagne, vous devez d'abord bloquer les commandes pour la campagne courante.</strong></p>
<?php
} else {
?>
<p><strong>Attention : démarrer une nouvelle campagne archivera celle-ci.</strong></p>
<p><a href="<?php echo root ?>/campagne.php/nouvelleCampagne">Démarrer une nouvelle campagne</a></p>
<?php
}
?>

<h2>Campagne courante</h2>

<p><span>Numéro : </span><?php echo $o_campagne['id'] ?><br/>
<span>Début : </span><?php echo $o_campagne['date_debut'] ?><br/>
<span>État : </span>
<?php 
/* Etat ouverte ou fermée */
if ($o_campagne['etat'] == 1) {
?>
    <span class="campagne_ouverte">ouverte</span>
</p>
<p><a href="<?php echo root ?>/campagne.php/gererCampagne?etat=0">Bloquer les commandes pour la campagne courante</a></p>
<?php
} else {
?>
    <span class="campagne_fermee">fermée</span>
</p>
<p><a href="<?php echo root ?>/campagne.php/gererCampagne?etat=1">Ouvrir les commandes pour la campagne courante</a></p>
<?php
}
?>

<h2>Campagnes précédentes</h2>

<?php
if ($to_oldCampagne == null or $to_oldCampagne == array()) {
?>
    <p class="message">Il n'y a aucune campagne archivée.</p>
<?php
} else {
    foreach ($to_oldCampagne as $o_oldCampagne) {
?>
<h3><span>Campagne n° </span><?php echo $o_oldCampagne['id'] ?></h3>
<p><span>Début : </span><?php echo $o_oldCampagne['date_debut'] ?><br/>
<span>État : </span>
<?php
        /* Etat ouverte ou fermée */
        if ($o_oldCampagne['etat'] == 1) {
?>
    <span class="campagne_ouverte">ouverte</span><br/>
<?php
        } else {
?>
    <span class="campagne_fermee">fermée</span><br/>
<?php
        }
?>
    <a href="<?php echo root ?>/utilisateurAyantCommandE.php/utilisateurAyantCommandE?idOldCampagne=<?php echo $o_oldCampagne['id'] ?>">Commandes Utilisateur</a> |
    <a href="<?php echo root ?>/fournisseur.php/fournisseursChoisis?idOldCampagne=<?php echo $o_oldCampagne['id'] ?>">Commandes Fournisseur</a> |
    <a href="<?php echo root ?>/articlesCommandEs.php/articlesCommandEs?idOldCampagne=<?php echo $o_oldCampagne['id'] ?>">Articles commandés</a> |
    <a href="<?php echo root ?>/article.php/afficherArticle?idOldCampagne=<?php echo $o_oldCampagne['id'] ?>">Gérer les articles</a>
</p>
<?php
    }
}
?>
