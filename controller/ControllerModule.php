<?php
require_once File::build_path(array('model', 'ModelModule.php'));

class ControllerModule
{

    protected static $object = 'module';

    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeModule'])) {
                $module=ModelModule::select($_GET['codeModule']);
                if(!$module) ControllerMain::erreur("Le module n'existe pas");
                else {
                    $view='detail';
                    $pagetitle='Module : '.$module->nommer().' : '.$module->getNomModule();
                    require_once File::build_path(array('view','view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}