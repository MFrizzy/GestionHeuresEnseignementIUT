<?php
require_once File::build_path(array('model', 'ModelUniteDEnseignement.php'));
require_once File::build_path(array('model', 'ModelModule.php'));

class ControllerUniteDEnseignement
{

    public static $object='uniteDEnseignement';

    /**
     * Affiche les détails d'un UE grace à son idUE @var $_GET['nUE']
     *
     * Il affiche aussi les Modules lié à cet UE
     * S'il manque l'idUE, l'utilisateur est redirigé vers une erreur
     * Si l'UE n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelUniteDEnseignement::select()
     * @uses ModelModule::selectAllByNUE()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nUE'])) {
                $ue = ModelUniteDEnseignement::select($_GET['nUE']);
                if (!$ue) ControllerMain::erreur("Cet unité d'enseignement n'existe pas");
                else {
                    $modules=ModelModule::selectAllByNUE($ue->getNUE());
                    $view='detail';
                    $pagetitle='UE : '.$ue->nommer();
                    require_once File::build_path(array('view','view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}