<?php

class ControllerMain
{
    protected static $object = 'main';

    public static function erreur($erreur = '')
    {
        if (isset($_SESSION['login'])) {
            $view = 'erreur';
            $pagetitle = 'Erreur';
            require File::build_path(array('view', 'view.php'));
        } else {
            ControllerUser::connect();
        }

    }

    public static function home() {
        if(isset($_SESSION['login'])) {
            $view = 'home';
            $pagetitle='Accueil';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }
}