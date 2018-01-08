<?php
require_once File::build_path(array('model', 'ModelDepartement.php'));
require_once File::build_path(array('model', 'ModelDiplome.php'));

class ControllerDepartement
{

    private static $object = 'departement';

    /**
     * Affiche une liste de tous les départements
     *
     * Affiche une erreur s'il n'y a pas de départements
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelDepartement::selectAll();
            if (!$tab) ControllerMain::erreur("Il n'y a pas de départements");
            else {
                $view = 'list';
                $pagetitle = 'Departements';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerUser::connect();
    }

    /**
     * Affiche les détils d'un département grace à son code @var $_GET ['codeDepartement']
     *
     * Affiche aussi les diplomes appartenant à ce département
     *
     * S'il n'y a pas de codeDepartement, l'utilisateur est redirigé vers une erreur
     * Si le département n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelDepartement::select()
     * @uses ModelDiplome::selectAllByDepartement()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeDepartement'])) {
                $dep = ModelDepartement::select($_GET['codeDepartement']);
                if (!$dep) ControllerMain::erreur("Le departement n'existe pas");
                else {
                    $tab = ModelDiplome::selectAllByDepartement($_GET['codeDepartement']);
                    $view = 'detail';
                    $pagetitle = 'Departement : ' . $dep->getNomDepartement();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'un département
     *
     * @uses ModelBatiment::selectAll()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $dep = new ModelDepartement();
            $batiments = ModelBatiment::selectAll();
            $view = 'update';
            $pagetitle = 'Nouveau département';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Créé le département à partir des informations fournies grace au formulaire de création
     *
     * S'il manque des informations, l'utilisateur est redirigé vers une erreur
     * Si la création échoue, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelDepartement::save()
     * @uses ControllerDepartement::readAll()
     *
     * @see  ControllerDepartement::create()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeDepartement']) &&
                isset($_POST['nomDepartement']) &&
                isset($_POST['nomBatiment'])) {
                if (!ModelDepartement::save(array(
                    'codeDepartement' => $_POST['codeDepartement'],
                    'nomDepartement' => $_POST['nomDepartement'],
                    'nomBatiment' => $_POST['nomBatiment']
                ))) ControllerMain::erreur("Impossible de créer le département");
                else {
                    ControllerDepartement::readAll();
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de maj d'un département identifié par son codeDepartement @var $_GET ['codeDepartement']
     *
     * S'il manque le codeDepartement, l'utilisateur est redirigé vers une erreur
     * Si le département n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelDepartement::select()
     * @uses ModelBatiment::selectAll()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeDepartement'])) {
                $dep = ModelDepartement::select($_GET['codeDepartement']);
                if (!$dep) ControllerMain::erreur("Le departement n'existe pas");
                else {
                    $batiments = ModelBatiment::selectAll();
                    $view = 'update';
                    $pagetitle = 'Nouveau département';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Modifie le département dans la BDD grâce aux informations dans @var $_POST
     *
     * S'il manque des informations, l'utilisateur est redirigé vers une erreur
     * Si la maj ne fonctionne pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelDepartement::update()
     * @uses ControllerDepartement::readAll()
     *
     * @see ControllerDepartement::update()
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeDepartement']) &&
                isset($_POST['nomDepartement']) &&
                isset($_POST['nomBatiment'])) {
                if(!ModelDepartement::update(array(
                    'codeDepartement' => $_POST['codeDepartement'],
                    'nomDepartement' => $_POST['nomDepartement'],
                    'nomBatiment' => $_POST['nomBatiment']
                ))) ControllerMain::erreur("Impossible de modifier le département");
                else ControllerDepartement::readAll();
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Supprime le département grace à son codeDepartement @var $_GET['codeDepartement']
     *
     * S'il n'y a pas de codeDepartement, l'utilisateur est redirigé vers une erreur
     * Si la suppression ne fonctionne pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelDepartement::delete()
     * @uses ControllerDepartement::readAll()
     */
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if(isset($_GET['codeDepartement'])) {
                if(!ModelDepartement::delete($_GET["codeDepartement"])) ControllerMain::erreur("Impossible de supprimer ce département");
                else ControllerDepartement::readAll();
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}