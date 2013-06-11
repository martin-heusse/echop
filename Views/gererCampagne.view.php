<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Gérer la campagne courante</h1>

<p>Les utilisateurs peuvent commander des articles tant que la campagne est ouverte.<br/>
Vous pouvez à tout moment bloquer les commandes ou les ré-ouvrir.<br/>
Démarrer une nouvelle campagne archive la campagne en cours et en démarre une nouvelle.</p>

<h2>Campagne courante</h2>


<p><span>Numéro : </span><?php echo $o_campagne['id'] ?><br/>
<span>Début : </span><?php echo $o_campagne['date_debut'] ?><br/>
<span>État : </span>
<?php 
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
