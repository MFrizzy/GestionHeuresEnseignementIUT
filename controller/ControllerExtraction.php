<?php

class ControllerExtraction
{

    protected static $object = 'extraction';

    public static function extract()
    {
        if(isset($_SESSION['login'])) {
            $view='extract';
            $pagetitle='Importation des données';
            require_once File::build_path(array('view','view.php'));
        }
        else ControllerUser::connect();

    }

    public static function extracted()
    {

    }

}