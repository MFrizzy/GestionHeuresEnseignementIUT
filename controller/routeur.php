<?php

require_once File::build_path(array('controller', 'ControllerMain.php'));
require_once File::build_path(array('controller', 'ControllerExtraction.php'));
require_once File::build_path(array('controller', 'ControllerUser.php'));
require_once File::build_path(array('controller', 'ControllerBatiment.php'));
require_once File::build_path(array('controller', 'ControllerSalle.php'));
require_once File::build_path(array('controller', 'ControllerEnseignant.php'));
require_once File::build_path(array('controller', 'ControllerDepartement.php'));

if (isset($_GET['controller'])) {
    $controller_class = 'Controller' . ucfirst($_GET['controller']);
} else {
    $controller_class = 'ControllerMain';
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'erreur';
}

if (class_exists($controller_class)) {
    if (in_array($action, get_class_methods("$controller_class"))) {
        $controller_class::$action();
    } else {
        ControllerMain::erreur("Action inexistante");
    }
} else {
    ControllerMain::erreur("Controller inexistant");
}