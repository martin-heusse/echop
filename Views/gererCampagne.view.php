<p><a class="action_navigation" href="<?php echo root ?>">Retour</a></p>

<h1>Gérer la campagne en cours</h1>

<h2>Campagne en cours</h2>


<p><span>Numéro : </span><?php echo $o_campagne['id'] ?><br/>
<span>Début : </span><?php echo $o_campagne['date_debut'] ?><br/>
<span>État : </span>
<?php 
if ($o_campagne['etat'] == 1) {
?>
    <span class="campagne_ouverte">ouverte</span>
</p>
<p><a href="<?php echo root ?>/campagne.php/gererCampagne?etat=0">Bloquer les commandes pour la campagne en cours</a></p>
<?php
} else {
?>
    <span class="campagne_fermee">fermée</span>
</p>
<p><a href="<?php echo root ?>/campagne.php/gererCampagne?etat=1">Ouvrir les commandes pour la campagne en cours</a></p>
<?php
}
?>

<h2>Nouvelle campagne</h2>

<p><a href="<?php echo root ?>/campagne.php/nouvelleCampagne">Démarrer une nouvelle campagne</a><br/>
<strong>Attention : cette action est irréversible.</strong></p>
