<!-- interface de parcours d'historique des campagnes pour utilisateur -->
<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Historique des campagnes</h1>


<?php
foreach ($to_campagne as $o_campagne) {
?>
    

<p> <a href="<?php echo root ?>/mesCommandes.php/mesVieillesCommandes?id_camp=<?php echo $o_campagne['id'] ?>">Explorer la campagne n°<?php echo $o_campagne['id']; ?></a>

<?php }
?>