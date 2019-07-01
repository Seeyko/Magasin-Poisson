<?php 
require_once '../lib/File.php';

require_once File::build_path(array('controller', 'ControllerCommande.php'));
require_once File::build_path(array('model', 'ModelPoisson.php'));

if($_POST['quantite'] >= 1){
    ControllerCommande::changeQuantity();
}else{
    ControllerCommande::removePanier();
}
?>