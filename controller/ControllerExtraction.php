<?php

class ControllerExtraction
{

    protected static $object = 'extraction';

    public static function extract()
    {
        $view='extract';
        $pagetitle='Importation des données';
        require_once File::build_path(array('view','view.php'));
    }

    public static function extracted()
    {

    }

}