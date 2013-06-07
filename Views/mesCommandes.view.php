<h1>Mes Commandes</h1>
<table>
<tr>
<th>
</th>
<?php 
foreach($to_commande as $produit) 
{
?>
  <tr> 
<?php

    foreach($produit as $element)
    {
      ?>
      <td> $element </td>
<?php
	}
?>
</tr>
<?php
    }
?>
 

</table>
