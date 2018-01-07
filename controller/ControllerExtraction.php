<?php

require_once File::build_path(array('lib', 'Extraction.php'));
require_once File::build_path(array('model', 'ModelErreurExport.php'));

class ControllerExtraction
{

    protected static $object = 'extraction';

    public static function extract()
    {
        if (isset($_SESSION['login'])) {
            $view = 'extract';
            $pagetitle = 'Importation des données';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();

    }

    public static function extracted()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_FILES['extract'])) {
                $array = Extraction::csvToArray($_FILES['extract']["tmp_name"]);
                Extraction::ArrayToBDD($array);
                ControllerExtraction::readAll();
                require_once File::build_path(array("view", "view.php"));
            } else ControllerMain::erreur("Veuillez fournir un fichier");
        } else ControllerUser::connect();
    }

    public static function home()
    {
        if (isset($_SESSION['login'])) {
            $view = 'home';
            $pagetitle = 'Erreurs';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['p'])) {
                $p = intval($_GET['p']);
                if ($p > ModelErreurExport::getNbP()) $p = ModelErreurExport::getNbP();
            } else $p = 1;
            $max = ModelErreurExport::getNbP();
            $tab = ModelErreurExport::selectByPage($p);
            $view = 'error';
            $pagetitle = 'Erreur';
            require_once File::build_path(array("view", "view.php"));
        } else ControllerUser::connect();
    }

    public static function tentative()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['idErreur'])) {
                $erreur = ModelErreurExport::select($_GET['idErreur']);
                if (!$erreur) ControllerMain::erreur("L'erreur n'exite pas..");
                else {
                    if (Extraction::erreurToBD($erreur)) {
                        echo "cban";
                    } else {
                        echo ')=';
                    }
                }
            }
        } else ControllerUser::connect();
    }

    //TODO Verifier utilitée
    public static function readAllType()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['typeErreur'])) {
                $redirct = $_POST['typeErreur'];
                switch ($redirct) {
                    case 'statut':
                        ControllerExtraction::solveStatuts();
                        break;
                    case 'departementEns':
                        ControllerExtraction::solveDepEns();
                        break;
                    case 'Département invalide':
                        ControllerExtraction::solveDepInv();
                        break;
                    case 'autre':
                        ControllerMain::erreur("En cours d'implémentation");
                        break;
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function solveStatuts()
    {
        if (isset($_SESSION['login'])) {
            $statuts = ModelErreurExport::selectAllStatuts();
            if (!$statuts) ControllerMain::erreur("Il n'y a pas de statuts invalides");
            else {
                $modelStatuts = ModelStatutEnseignant::selectAll();
                $view = 'solveStatut';
                $pagetitle = 'Resolution erreurs de statuts';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerUser::connect();
    }

    public static function solveDepEns()
    {
        if (isset($_SESSION['login'])) {
            $depEns = ModelErreurExport::selectAllDepEns();
            if (!$depEns) ControllerMain::erreur("Il n'y a pas de départements d'enseignant invalides");
            else {
                $dep = ModelDepartement::selectAll();
                $view = 'solveDepEns';
                $pagetitle = 'Resolution erreurs de statuts';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerUser::connect();
    }

    public static function solveDepInv()
    {
        if (isset($_SESSION['login'])) {
            $depInv = ModelErreurExport::selectAllDepInv();
            if (!$depInv) ControllerMain::erreur("Il n'y a pas de départements invalides");
            else {
                $dep = ModelDepartement::selectAll();
                $view = 'solveDepInv';
                $pagetitle = 'Resolution erreurs de statuts';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerUser::connect();
    }

    public static function solvedStatuts()
    {
        if (isset($_SESSION['login'])) {
            foreach ($_POST as $cle => $item) {
                /**
                 * @var $statut [0] est le statut
                 * @var $statut [1] est le type statut
                 */
                $cle = str_replace("_", " ", $cle);
                $statut = explode('/', $cle);
                if ($item != 'rien') {
                    $idErreurs = ModelErreurExport::selectIdErreurStatut($statut[0], $statut[1]);
                    if (!$idErreurs) echo 'crack';
                    else {
                        if ($item == 'nouveau') {
                            // Créer nouveau statut
                            ModelStatutEnseignant::save(array(
                                'statut' => $statut[0],
                                'typeStatut' => $statut[1]
                            ));
                        } else {
                            // Changer le statut des erreurs par celui selectionné par l'utilisateur
                            foreach ($idErreurs as $idErreur) {
                                ModelErreurExport::update(array(
                                    'idErreur' => $idErreur['idErreur'],
                                    'statut' => $statut[0],
                                    'typeStatut' => $statut[1]
                                ));
                            }
                        }
                        // Refaire entrer les valeurs dans la bdd
                        foreach ($idErreurs as $idErreur) {
                            Extraction::erreurToBD(ModelErreurExport::select($idErreur['idErreur']));
                        }
                    }
                }
            }
            ControllerExtraction::solveStatuts();
        } else ControllerUser::connect();
    }
}