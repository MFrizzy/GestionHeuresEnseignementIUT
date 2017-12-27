<?php
require_once File::build_path(array('model', 'ModelDepartement.php'));
require_once File::build_path(array('model', 'ModelDiplome.php'));

class ControllerDepartement
{

    private static $object = 'departement';

    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelDepartement::selectAll();
            if (!$tab) ControllerMain::erreur("Il n'y a pas de départements");
            else {
                $view = 'list';
                $pagetitle = 'Departements';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerUser::connect();
    }

    public static function read()
    {
        if(isset($_SESSION['login'])) {
            if(isset($_GET['codeDepartement'])) {
                $dep=ModelDepartement::select($_GET['codeDepartement']);
                if(!$dep) ControllerMain::erreur("Le departement n'existe pas");
                else {
                    $tab=ModelDiplome::selectAllByDepartement($_GET['codeDepartement']);
                    $view='detail';
                    $pagetitle='Departement : '.$dep->getNomDepartement();
                    require_once File::build_path(array('view','view.php'));
                }
            }
            else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}