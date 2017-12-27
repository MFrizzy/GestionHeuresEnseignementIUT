<?php
require_once File::build_path(array('model', 'ModelEnseignant.php'));

class ControllerEnseignant
{

    protected static $object = 'enseignant';

    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelEnseignant::selectAll();
            if (!$tab) ControllerMain::erreur("Il n'y a pas d'enseignants");
            else {
                $view = 'list';
                $pagetitle = 'Enseignants';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerUser::connect();
    }

    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeEns'])) {
                $ens = ModelEnseignant::select($_GET['codeEns']);
                if (!$ens) ControllerMain::erreur("L'enseignant n'existe pas");
                else {
                    $view = 'detail';
                    $pagetitle = 'Enseignant : ' . $_GET['codeEns'];
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur('Il manque des informations');
        } else ControllerUser::connect();
    }

}