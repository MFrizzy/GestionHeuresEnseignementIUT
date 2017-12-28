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

    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $ens = new ModelEnseignant();
            $departements = ModelDepartement::selectAll();
            $statuts = ModelStatutEnseignant::selectAll();
            $view = 'update';
            $pagetitle = 'Créer un enseignant';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeEns']) &&
                isset($_POST['nomEns']) &&
                isset($_POST['prenomEns']) &&
                isset($_POST['codeDepartement']) &&
                isset($_POST['codeStatut'])) {
                $data = array(
                    'codeEns' => $_POST['codeEns'],
                    'nomEns' => $_POST['nomEns'],
                    'prenomEns' => $_POST['prenomEns'],
                    'codeDepartement' => $_POST['codeDepartement'],
                    'codeStatut' => $_POST['codeStatut']
                );
                if(!ModelEnseignant::save($data)) ControllerMain::erreur("Impossible d'enregistrer l'enseignant");
                else header("location: index.php?controller=enseignant&action=read&codeEns=".$_POST['codeEns']);
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}