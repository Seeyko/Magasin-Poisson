<?php 
echo("<div id='commandeList'>");
foreach ($commandes as $key => $command){
    echo("<div class='commande'>");
    echo("<div class='commandeDetail'>Commandes $key :</div>");    
    require File::build_path(array('view', 'command', 'detail.php'));
    echo("</div>");
}
echo("</div>");
?>