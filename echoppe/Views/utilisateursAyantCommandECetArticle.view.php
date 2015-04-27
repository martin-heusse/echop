<!--affiche la liste des utilisateur qui ont commandé un article donné -->
<div id="retour">
<p><a class="action_navigation" href="<?php echo root ?>/articlesCommandEs.php/articlesCommandEs
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "?idOldCampagne=".$i_idCampagne;
}
?>
">Retour aux articles commandés</a></p>
</div>

<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
?>
    <span class="historique">[Historique de la campagne n°<?php echo $i_idCampagne ?>]</span>
<?php
}
?>

<h1>Utilisateurs ayant commandé cet article</h1>

<?php
if ($to_utilisateur == null or $to_utilisateur == array()) {
    /* on affiche la liste des utilisateurs si elle est non vide */
?>
<p class="message">Aucun utilisateur n'a commandé l'article <strong><?php echo $s_nomArticle ?></strong>.</p>
<?php
} else {
?>
<p>Liste des utilisateurs ayant commandé l'article <strong><?php echo $s_nomArticle ?></strong>.<br/>
Cliquez sur un nom pour voir ses commandes.</p>

<table>
    <tr>
        <th>Utilisateur</th>
        <th>Quantité commandée</th>
    </tr>
<?php
    $i_numLigne = 0;
    foreach ($to_utilisateur as $o_utilisateur) {
?>
    <tr class="ligne_article<?php echo $i_numLigne ?>">
        <td><a href="<?php echo root ?>/articlesCommandEs.php/commandeUtilisateurPourCetArticle?idArticle=<?php echo $i_idArticle ?>&idUtilisateur=<?php echo $o_utilisateur['id']?>
<?php
/* Si navigation dans l'historique */
if ($b_historique == 1) {
    echo "&idOldCampagne=".$i_idCampagne;
}
?>
"><?php echo $o_utilisateur['login'] ?></a></td>
        <td class="centrer"><?php echo $o_utilisateur['quantite'].$s_unite ?> (<?php $nbr_unites = $o_utilisateur['quantite']/$i_poidsPaquetClient ; echo $nbr_unites ?> Unités)</td>
    </tr>
<?php
        $i_numLigne = ($i_numLigne + 1) % 2;
    }
?>
    <tr>
        <th class="left">Quantité totale commandée</th>
        <td class="centrer"><?php echo $i_quantiteTotale.$s_unite?> </td>
    </tr>
    <tr>
        <th class="left">Quantité pour le colisage </th>
        <td class="centrer">multiple de <?php echo $i_colisage.$s_unite ?> (<?php $nbr_manque = $i_colisage/$i_poidsPaquetClient ; echo $nbr_manque ?> Unités)</td>
    </tr>
    <tr>
        
        <th class="left">Quantité manquante </th>
        <td class="centrer"><?php echo $i_manque.$s_unite ?> (<?php $nbr_manque = $i_manque/$i_poidsPaquetClient ; echo $nbr_manque ?> Unités)</td>
    </tr>
    <?php
    if(Administrateur::isAdministrateur($_SESSION['idUtilisateur'])) {
    ?>

    <tr>
        <form method="post" action="articlesCommandEs.php/forceUtilisateur?idArticle=<?php echo $i_idArticle ?>&idOldCampagne=<?php echo $i_idCampagne ?>"
        >
        
        <td><select name="forceUtilisateur">
        <?php foreach($not_utilisateur as $o_utilisateur) { ?>
        <option value=<?php echo $o_utilisateur['id']?>> <?php echo $o_utilisateur['nom']?>  <?php echo $o_utilisateur['prenom']?> (<?php echo $o_utilisateur['login']?>)</option>
        <?php }?>
        </select></td>
        <td class="centrer"><input class="input_quantite" type="text" name="forceQuantite" value="0"/>
        <input class="input_valider" type="submit" value="paf !"/></td>
        </form>
    </tr>
    <?php }?>
</table>
<?php
}
?>
