<?php

require_once File::build_path(['model', 'ModelSalle.php']);

class ControllerSalle
{

    protected static $object = 'salle';

    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nomBatiment']) && $_GET['numSalle']) {
                $salle = ModelSalle::select($_GET['nomBatiment'], $_GET['numSalle']);
                if (!$salle) ControllerMain::erreur('La salle n\'existe pas');
                else {
                    $view = 'detail';
                    $pagetitle = 'Salle : '. $_GET['nomBatiment'] . '_' . $_GET['numSalle'];
                    require_once File::build_path(array('view','view.php'));
                }
            } else ControllerMain::erreur('Il manque des informations');
        } else ControllerUser::connect();
    }


}