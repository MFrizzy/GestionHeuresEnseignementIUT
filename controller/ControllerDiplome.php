<?php
require_once File::build_path(array('model', 'ModelDiplome.php'));
require_once File::build_path(array('model', 'ModelUniteDEnseignement.php'));

class ControllerDiplome
{

    protected static $object = 'diplome';

    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeDiplome'])) {
                $diplome = ModelDiplome::select($_GET['codeDiplome']);
                if (!$diplome) ControllerMain::erreur('Le diplome n\' existe pas');
                else {
                    $tab = ModelUniteDEnseignement::selectAllByDiplome($_GET['codeDiplome']);
                    $view = 'detail';
                    $pagetitle = '' . $diplome->getTypeDiplome() . ' ' . $diplome->getCodeDepartement()->getNomDepartement(). ' ' .$diplome->getNomDiplome();
                    $pagetitle = htmlspecialchars($pagetitle);
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur('Il manque des informations');
        } else ControllerUser::connect();
    }
}