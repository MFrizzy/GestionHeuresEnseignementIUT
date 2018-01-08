<?php

require_once File::build_path(array('model', 'ModelBatiment.php'));
require_once File::build_path(array('model', 'ModelSalle.php'));

class ControllerBatiment
{

    protected static $object = 'batiment';

    /**
     * Affiche la liste de tous les batiments
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelBatiment::selectAll();
            $view = 'list';
            $pagetitle = "Bâtiments";
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Affiche le details d'un batiment identifié par son nomBatiment @var $_GET ['nomBatiment']
     *
     * Il affiche aussi la liste des salles dans la batiment
     * S'il n'y a pas de nomBatiment, l'utilisateur sera redirigé vers une erreur
     * Si le batiment n'existe pas, l'utilisateur sera redirigé vers une erreur
     * S'il n'y a aucune salle dans le batiment, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelBatiment::select()
     * @uses ModelSalle::selectAllByBatiment()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nomBatiment'])) {
                $batiment = ModelBatiment::select($_GET['nomBatiment']);
                if ($batiment == false) ControllerMain::erreur("Ce batiment n'existe pas");
                else {
                    $tab = ModelSalle::selectAllByBatiment($_GET['nomBatiment']);
                    if ($tab == false) ControllerMain::erreur('Aucune salles dans ce batiment');
                    else {
                        $pagetitle = 'Batiment ' . $_GET['nomBatiment'];
                        $view = 'detail';
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Crée un batiment à partir des informations du formulaire via la méthode POST
     *
     * @uses ModelBatiment::save()
     * @uses ControllerBatiment::readAll()
     *
     * @see ControllerBatiment::readAll()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nomBatiment'])) {
                if (ModelBatiment::save(['nomBatiment' => $_POST['nomBatiment']])) ControllerBatiment::readAll();
                else ControllerMain::erreur("Impossible de créer le batiment");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Supprime un batiment grace à son nomBatiment @var $_GET['nomBatiment']
     *
     * S'il n'y a pas de nomBatiment, l'utilisateur sera redirigé vers une erreur
     * Si la suppression ne fonctionne pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelBatiment::delete()
     * @uses ControllerBatiment::readAll()
     */
    public static function delete()
    {
        if(isset($_SESSION['login'])) {
            if(isset($_GET['nomBatiment'])) {
                if(ModelBatiment::delete($_GET['nomBatiment'])) ControllerBatiment::readAll();
                else ControllerMain::erreur("Impossible de supprimer le batiment");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}