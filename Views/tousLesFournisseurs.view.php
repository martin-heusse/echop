<h1>Liste des fournisseurs</h1>

<ul>
<?php
foreach ($to_fournisseur as $o_fournisseur) {
?>  
    <li><?php echo $o_fournisseur['nom'] ?></li>
<?php
}
?>
</ul>
