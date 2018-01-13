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
     * S'il n'y a pas de nUE, l'utilisateur sera redirigé vers une erreur
     * Si l'unité d'enseignement n'existe pas, l'utilisateur sera redirigé vers une erreur
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

    /**
     * Créé un module à partir des informations fournis en méthode POST via @see ControllerModule::create()
     *
     * S'il manque des informations, l'utilisateur sera redirigé vers une erreur
     * Si le module exist déjà, l'utilisateur sera redirigé vers une erreur
     * Si l'enregistrement echoue, l'utilisateur sera redirigé vers une erreur
     * Sinon l'utilisateur vera les détails du nouveau module fraichement créé
     *
     * @uses ModelModule::save()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nUE']) &&
                isset($_POST['nomModule']) &&
                isset($_POST['numModule']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance de ce module
                 */
                $testModule = ModelModule::selectBy($_POST['nUE'], $_POST['numModule']);
                if ($testModule) ControllerMain::erreur("Ce module existe déjà");
                else {
                    /**
                     * Enregistrement dans la base de donnée
                     * @uses ModelModule::save()
                     */
                    $data = array(
                        'nUE' => $_POST['nUE'],
                        'numModule' => $_POST['numModule'],
                        'nomModule' => $_POST['nomModule'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresCM' => $_POST['heuresCM']
                    );
                    if (!ModelModule::save($data)) ControllerMain::erreur("Impossible de créer le module");
                    else {
                        $module = ModelModule::selectBy($_POST['nUE'], $_POST['numModule']);
                        $view = 'detail';
                        $pagetitle = 'Module : ' . $module->nommer() . ' : ' . $module->getNomModule();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de modification d'un module identifié par @var $_GET ['codeModule']
     *
     * S'il n'y a pas de codeModule, l'utilisateur sera redirigé vers une erreur
     * Si le module n'existe pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelModule::select()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeModule'])) {
                $module = ModelModule::select($_GET['codeModule']);
                if (!$module) ControllerMain::erreur("Ce module n'existe pas");
                else {
                    $view = 'update';
                    $pagetitle = 'Modification d\'un module';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Modifie un module grace aux informations du formulaire @see ControllerModule::update() envoyé via la méthode POST
     *
     * S'il manque des informations, l'utilisateur sera redirigé vers une erreur
     * Si le module identifié par @var $_POST['codeModule'] n'existe pas, l'utilisateur sera redirigé vers une erreur
     * Si un module similaire existe, l'utilisateur sera redirigé vers une erreur
     * Si la modification echoue, l'utilisateur sera redirigé vers une erreur
     * Sinon il sera redirigé vers les détails du module modifié
     *
     * @uses ModelModule::select()
     * @uses ModelModule::selectBy()
     * @uses ModelModule::update()
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeModule']) &&
                isset($_POST['nomModule']) &&
                isset($_POST['numModule']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance d'un module similaire
                 */
                $module = ModelModule::select($_POST['codeModule']);
                if(!$module) ControllerMain::erreur("Ce module n'existe pas");
                else {
                    $testModule = ModelModule::selectBy($module->getNUE()->getNUE(),$_POST['numModule']);
                    if(!$testModule || $testModule=$module) {
                        /**
                         * Enregistrement dans la base de donnée
                         * @uses ModelModule::save()
                         */
                        $data = array(
                            'codeModule' => $_POST['codeModule'],
                            'numModule' => $_POST['numModule'],
                            'nomModule' => $_POST['nomModule'],
                            'heuresTP' => $_POST['heuresTP'],
                            'heuresTD' => $_POST['heuresTD'],
                            'heuresCM' => $_POST['heuresCM']
                        );
                        if (!ModelModule::update($data)) ControllerMain::erreur("Impossible de modifier le module");
                        else {
                            $module = ModelModule::select($_POST['codeModule']);
                            $view = 'detail';
                            $pagetitle = 'Module : ' . $module->nommer() . ' : ' . $module->getNomModule();
                            require_once File::build_path(array('view', 'view.php'));
                        }
                    } else ControllerMain::erreur("Ce module existe déjà");
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}