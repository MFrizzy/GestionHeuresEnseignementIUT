<?php
require_once File::build_path(array('model', 'ModelModule.php'));

class ControllerModule
{

    protected static $object = 'module';

    /**
     * Affiche les details d'un module identifié grace à @var $_GET ['codeModule']
     *
     * S'il n'y a pas de codeModule, l'utilisateur est redirigé vers une erreur
     * Si le module n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelModule::select()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeModule'])) {
                $module = ModelModule::select($_GET['codeModule']);
                if (!$module) ControllerMain::erreur("Le module n'existe pas");
                else {
                    $view = 'detail';
                    $pagetitle = 'Module : ' . $module->nommer() . ' : ' . $module->getNomModule();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'un module associé à une unité d'enseignement d'un diplome identifié par @var $_GET ['nUE']
     *
     * @uses ModelUniteDEnseignement::select()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nUE'])) {
                $ue = ModelUniteDEnseignement::select($_GET['nUE']);
                if (!$ue) ControllerMain::erreur("Cette unité d'enseignement n'existe pas");
                else {
                    $module = new ModelModule();
                    $module->setNUE($ue);
                    $view = 'update';
                    $pagetitle = 'Création d\'un nouveau module';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function update()
    {
        if(isset($_SESSION['login'])) {
            if(isset($_GET['codeModule'])) {
                $module = ModelModule::select($_GET['codeModule']);
                if(!$module) ControllerMain::erreur("Ce module n'existe pas");
                else {
                    $view = 'update';
                    $pagetitle = 'Création d\'un nouveau module';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}