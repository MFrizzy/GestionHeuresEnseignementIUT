<?php
require_once File::build_path(array('model', 'ModelUniteDEnseignement.php'));
require_once File::build_path(array('model', 'ModelModule.php'));

class ControllerUniteDEnseignement
{

    public static $object='uniteDEnseignement';

    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nUE'])) {
                $ue = ModelUniteDEnseignement::select($_GET['nUE']);
                if (!$ue) ControllerMain::erreur("Cet unité d'enseignement n'existe pas");
                else {
                    $modules=ModelModule::selectAllByNUE($ue->getNUE());
                    $view='detail';
                    $pagetitle='UE : '.$ue->getNUE();
                    require_once File::build_path(array('view','view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}