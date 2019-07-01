<?php 
require_once '../lib/File.php';

require_once File::build_path(array('controller', 'ControllerCommande.php'));
require_once File::build_path(array('model', 'ModelPoisson.php'));

ControllerCommande::removePanier($_POST['quantite']);
?>