<?php

require_once File::build_path(array('model', 'ModelBatiment.php'));
require_once File::build_path(array('model', 'ModelSalle.php'));

class ControllerBatiment
{

    protected static $object = 'batiment';

    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelBatiment::selectAll();
            $view = 'list';
            $pagetitle = "Bâtiments";
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nomBatiment'])) {
                $batiment = ModelBatiment::select($_GET['nomBatiment']);
                if ($batiment == false) ControllerMain::erreur("Ce batiment n'existe pas");
                else {
                    $tab = ModelSalle::selectAllByBatiment($_GET['nomBatiment']);
                    if ($tab == false) ControllerMain::erreur('Aucune salles');
                    else {
                        $pagetitle = 'Batiment ' . $_GET['nomBatiment'];
                        $view = 'detail';
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();

    }
}