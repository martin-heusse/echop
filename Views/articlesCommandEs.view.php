<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>

<h1>Articles commandés</h1>

<p>Liste de tous les articles commandés par les utilisateurs pendant la campagne en cours.<br/>
Cliquez sur l'un des articles pour voir la liste de tous les utilisateurs l'ayant commandé.</p>

<table>
    <tr>
        <th>Article</th>
<?php
    if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
?>
        <th>Quantité totale commandée</th>
        <th>Colisage</th>
<?php
    }
?>
        <th>Manque</th>
    </tr>
<?php
$i_numLigne = 0;
foreach ($to_article as $o_article) {
?>
    <tr class="ligne_article<?php echo $i_numLigne?>">
        <td>
<?php
    if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
?>
<a href="<?php echo root ?>/commande.php/utilisateursAyantCommandECetArticle?idArticle=<?php echo $o_article['id_article']?>">
<?php 
}
echo $o_article['nom'];
    if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])){?></a>
<?php }
?>
</td>
<?php
    if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
?>
        <td class="centrer"><?php echo $o_article['quantite_totale'].$o_article['unite']?></td>
        <td class="centrer">multiple de <?php echo $o_article['colisage'].$o_article['unite']?></td>
<?php
    }
if($o_article['manque']!= 0) {
?> 
        <td class="centrer col_coloree"> 
<strong> 
<?php echo $o_article['manque'].$o_article['unite']?></strong>
<?php
} else {
?>
        <td class="centrer"><?php 
    echo $o_article['manque'].$o_article['unite']; }?>

</td>
    </tr>
<?php
    $i_numLigne = ($i_numLigne + 1) % 2;
}
?>
</table>
