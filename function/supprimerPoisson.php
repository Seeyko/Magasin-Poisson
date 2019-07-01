<?php 
require_once '../lib/File.php';

require_once File::build_path(array('controller', 'ControllerPoisson.php'));
require_once File::build_path(array('model', 'ModelPoisson.php'));
ControllerPoisson::delete();
?>