<!--Affiche des commandes pour chaque fournisseur-->
<div id="retour">
<p><a class="action_navigation" href="<?php echo root ?>/fournisseur.php/fournisseursChoisis
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "?idOldCampagne=".$i_idCampagne;
}
?>
">Retour aux commandes par fournisseur</a></p>
</div>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
    <span class="historique">[Historique de la campagne n°<?php echo $i_idCampagne ?>]</span>
<?php
}

?>
<h1>Commande fournisseur <?php echo $to_article[0]['nom_fournisseur']?></h1>
<?php
if($i_nbreArticle != 0) {
/* Affichage du tableau des commandes pour un fournisseur donné */
?>
<table>
    <tr>
        <th>Code Fournisseur</th>
        <th>Article</th>
        <th>Quantité</th>
        <th>Prix unitaire</th>
        <th>Prix Total</th>
    </tr>
    
    <div id="columns">
<?php
    $i_numLigne = 0;
    foreach ($to_article as $o_article) {
        if ($o_article['quantite_totale'] != 0) {
?>
        <td class="centrer"><?php echo $o_article['code'] ?></td>
        <td><?php echo $o_article['nom'] ?></td>
        <td class="centrer"><?php echo $o_article['quantite_totale'].$o_article['unite']." (".$o_article['quantite_totale_unites']." unités)"?></td>
        <td align="center"> <!-- prix donnée par le fournisseur -->
                                <!-- montant -->
                                montant : <?php if ($o_article['prix_ttc_ht']) {echo $o_article['prix_ht'];}
                                        else {echo $o_article['prix_ttc'];} ?>
                                          <br />&euro; /
                                <!-- unite ou paquet -->
                                <?php if ($o_article['vente_paquet_unite']) {echo "paquet";}
                                        else {echo $o_article['unite'];} ?>
                                <!-- HT ou TTC -->
                                &nbsp;
                                <?php if ($o_article['prix_ttc_ht']) {echo "HT";}
                                        else {echo "TTC";} ?>
                                
                            </td>
        <td class="centrer"><?php echo $o_article['montant_total'] ?>&euro;</td>
        </tr> </div>
<?php
        }
        $i_numLigne = ($i_numLigne + 1) % 2;

    }
?>
<td class="centrer"></td>
<td class="centrer"></td>
<td class="centrer"></td>
<td class="centrer"><b><?php echo 'Montant total'?></b></td>
<td class="centrer"><b><?php echo $f_montantTtc ?>&euro;</b></td>


</table>

<p><a href="<?php echo root ?>/fournisseur.php/exportCSV?idFournisseur=<?php echo $i_idFournisseur?>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "&idOldCampagne=".$i_idCampagne;
}
?>
"><img height="40" id="logo" src="<?php echo root ?>/Layouts/images/excel.png" alt="<?php echo $titre_page ?>" /></a></p>
<p><a href="<?php echo root ?>/fournisseur.php/exportPDF?idFournisseur=<?php echo $i_idFournisseur?>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "&idOldCampagne=".$i_idCampagne;
}
?>
"><img height="40" id="logo" src="<?php echo root ?>/Layouts/images/pdf.png" alt="<?php echo $titre_page ?>" /></a></p>
<?php
} else {
    /* Cas où aucun article n'a été commandé */
?>
<p class="message">Aucun produit n'a été commandé pour ce fournisseur.</p>
<?php
}
?>
<script src="../js/script.js"></script>
