<head>
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.shoppingList.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</head>
<body>
    <div id="retour">
<!-- interface de parcours d'historique des campagnes pour utilisateur -->
<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>
    </div>

<h1>Historique des campagnes</h1>


<div class="shoppingList">
    <ul>
<?php
foreach ($to_campagne as $o_campagne) {
?>
    

        <li> <p> <a href="<?php echo root ?>/mesCommandes.php/mesVieillesCommandes?id_camp=<?php echo $o_campagne['id'] ?>">Explorer la campagne n°<?php echo $o_campagne['id']; ?></a></li>

<?php }
?>
    </ul>
</div>
</body>