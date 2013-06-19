<!--Affiche des commandes pour chaque fournisseur-->
<p><a class="action_navigation" href="<?php echo root ?>/fournisseur.php/fournisseursChoisis
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "?idOldCampagne=".$i_idCampagne;
}
?>
">Retour aux commandes par fournisseur</a></p>

<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
    <span class="historique">[Historique de la campagne n°<?php echo $i_idCampagne ?>]</span>
<?php
}

?>
<h1>Commande fournisseur</h1>
<?php
if($i_nbreArticle != 0) {
/* Affichage du tableau des commandes pour un fournisseur donné */
?>
<table>
    <tr>
        <th>Article</th>
        <th>Quantité</th>
        <th>Prix Total</th>
    </tr>
<?php
    $i_numLigne = 0;
    foreach ($to_article as $o_article) {
        if ($o_article['quantite_totale'] != 0) {
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
        <td><?php echo $o_article['nom'] ?></td>
        <td class="centrer"><?php echo $o_article['quantite_totale'].$o_article['unite']?></td>
        <td class="centrer"><?php echo $o_article['montant_total'] ?>&euro;</td>
    </tr>
<?php
        }
        $i_numLigne = ($i_numLigne + 1) % 2;
    }
} else {
    /* Cas où aucun article n'a été commandé */
?>
<p class="message">Aucun produit n'a été commandé pour ce fournisseur.</p>
<?php
}
?>
</table>
