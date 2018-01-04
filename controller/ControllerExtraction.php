<?php

require_once File::build_path(array('lib', 'Extraction.php'));
require_once File::build_path(array('model', 'ModelErreurExport.php'));

class ControllerExtraction
{

    protected static $object = 'extraction';

    public static function extract()
    {
        if (isset($_SESSION['login'])) {
            $view = 'extract';
            $pagetitle = 'Importation des données';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();

    }

    public static function extracted()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_FILES['extract'])) {
                $array = Extraction::csvToArray($_FILES['extract']["tmp_name"]);
                Extraction::ArrayToBDD($array);
                $error = ModelErreurExport::selectAll();
                $view = 'error';
                $pagetitle = 'Erreur';
                //require_once File::build_path(array("view","view.php"));
            } else ControllerMain::erreur("Veuillez fournir un fichier");
        } else ControllerUser::connect();
    }

}