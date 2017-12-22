<?php

require_once File::build_path(array('controller', 'ControllerMain.php'));

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
}
else {
    $controller_class = 'ControllerProduct';
    $action = 'readAll';
    $controller_class::$action();
}