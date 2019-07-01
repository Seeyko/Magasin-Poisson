<?php
require (File::build_path(array(
    'controller',
    'ControllerPoisson.php'
)));
require (File::build_path(array(
    'controller',
    'ControllerUser.php'
)));

require (File::build_path(array(
        'controller',
        'ControllerCommande.php'
)));

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$error = null;
// On recupère l'action passée dans l'URL
if (count($_GET) == 0) {

    $controller = 'global';
    $view = 'accueil';
    $pagetitle = "Accueil";

    require_once (File::build_path(array(
        'view',
        'global',
        'view.php'
    )));
} else if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
    $controller_class = "Controller" . ucfirst($controller);
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if (class_exists($controller_class)) {

            $listMethod = get_class_methods($controller_class);
            if (in_array($action, $listMethod)) {
                $controller_class::$action();
            } else {
                $error = "pas $action dans $controller_class <br> $actual_link";
            }
        } else {
            $error = "$controller_class n'existe pas <br> $actual_link";
        }
    } else {
        $error = "action pas set<br>" . $actual_link;
    }
}
if (! is_null($error)) {

    $controller = 'global';
    $view = 'accueil';
    $pagetitle = "Accueil";
    echo("<h1>Pas par ici !</h1>");
    require (File::build_path(array(
        'view',
        'global',
        'view.php'
    )));
}
?>
