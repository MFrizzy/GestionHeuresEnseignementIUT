<?php
require_once File::build_path(array('model', 'ModelDiplome.php'));
require_once File::build_path(array('model', 'ModelUniteDEnseignement.php'));

class ControllerDiplome
{

    protected static $object = 'diplome';

    /**
     * Affiche les détails d'un diplome identifié grace à @var $_GET['codeDiplome']
     * 
     * Affiche aussi les UE et les modules appartenant à ce diplome
     *
     * S'il n'y a pas de codeDiplome, l'utilisateur est redirigé vers une erreur
     * Si le diplome n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelDiplome::select()
     * @uses ModelUniteDEnseignement::selectAllByDiplome();
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeDiplome'])) {
                $diplome = ModelDiplome::select($_GET['codeDiplome']);
                if (!$diplome) ControllerMain::erreur('Le diplome n\' existe pas');
                else {
                    $tab = $diplome->getModulesBySemestre();
                    $view = 'detail';
                    $pagetitle = $diplome->nommer();
                    $pagetitle = htmlspecialchars($pagetitle);
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur('Il manque des informations');
        } else ControllerUser::connect();
    }
}