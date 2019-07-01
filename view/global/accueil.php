<?php 
$tab_poisson = ModelPoisson::getAllPoissons();
require_once File::build_path(array('view', 'poisson', 'list.php'));
?>