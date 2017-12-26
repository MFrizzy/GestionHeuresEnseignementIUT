<?php

require_once File::build_path(array('model', 'ModelBatiment.php'));

class ControllerBatiment
{

    protected static $object = 'batiment';

    public static function readAll()
    {
        if(isset($_SESSION['login'])) {
            $tab = ModelBatiment::selectAll();
            $view='list';
            $pagetitle="Bâtiments";
            require_once File::build_path(array('view','view.php'));
        }
    }
}