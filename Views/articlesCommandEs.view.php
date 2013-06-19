<?php
/* vérifie si on navigue dans l'historique ou non */
if ($b_historique == 1) {
?>
<p><a class="action_navigation" href="<?php echo root ?>/campagne.php/gererCampagne">Retour à la gestion des campagnes</a></p>
<?php
} else {
?>
<p><a class="action_navigation" href="<?php echo root ?>">Retour à l'accueil</a></p>
<?php
}
?>


<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
    <span class="historique">[Historique de la campagne n°<?php echo $i_idCampagne ?>]</span>
<?php
}

/* affiche l'ensemble des commandes utilisateurs */
?>
<h1>Articles commandés</h1>

<?php
/* si on a pas d'article commandés */
if ($to_article == null or $to_article == array()) {
?>
    <p class="message">Aucun article n'a été commandé.</p>
<?php
} else {
?>
<p>Liste de tous les articles commandés par les utilisateurs pendant la campagne en cours.<br/>
<?php
    /* l'affichage diffère si on est un administrateur ou non
     * un administrateur peut accèder à des pages annexes à partir de celle-ci 
     * contrairement aux simples utilisateurs */
    if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
?>
Cliquez sur l'un des articles pour voir la liste de tous les utilisateurs l'ayant commandé.</p>
<?php
    }
    /* tableau d'affichage des résultats, les colonnes diffèrent en fonction du 
     * status de l'utilisateur */
?>
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
<a href="<?php echo root ?>/articlesCommandEs.php/utilisateursAyantCommandECetArticle?idArticle=<?php echo $o_article['id_article']?>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "&idOldCampagne=".$i_idCampagne;
}
?>
">
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
<?php
}
?>
