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
                ControllerExtraction::readAll();
                require_once File::build_path(array("view", "view.php"));
            } else ControllerMain::erreur("Veuillez fournir un fichier");
        } else ControllerUser::connect();
    }

    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['p'])) {
                $p = intval($_GET['p']);
                if ($p > ModelErreurExport::getNbP()) $p = ModelErreurExport::getNbP();
            } else $p = 1;
            $max = ModelErreurExport::getNbP();
            $tab = ModelErreurExport::selectByPage($p);
            $view = 'error';
            $pagetitle = 'Erreur';
            require_once File::build_path(array("view", "view.php"));
        } else ControllerUser::connect();
    }

    public static function tentative()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['idErreur'])) {
                $erreur=ModelErreurExport::select($_GET['idErreur']);
                if(!$erreur) ControllerMain::erreur("L'erreur n'exite pas..");
                else {
                    if(Extraction::erreurToBD($erreur)) {
                        echo "cban";
                    }
                    else {
                        echo ')=';
                    }
                }
            }
        } else ControllerUser::connect();
    }

}