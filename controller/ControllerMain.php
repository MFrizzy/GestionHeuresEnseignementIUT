<?php

class ControllerMain
{
    protected static $object = 'main';

    /**
     * Affiche une page d'erreur
     *
     * @param string $erreur : message d'erreur
     */
    public static function erreur($erreur = '')
    {
        if (isset($_SESSION['login'])) {
            $view = 'erreur';
            $pagetitle = 'Erreur';
            require File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Affiche la page d'accueil du site
     */
    public static function home()
    {
        if (isset($_SESSION['login'])) {
            $view = 'home';
            $pagetitle = 'Accueil';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    public static function billet()
    {
        if (isset($_SESSION['login'])) {
            $view = 'billet';
            $pagetitle = 'Billet';
            require_once File::build_path(array('view', 'view.php'));
        }
    }

    public static function envoyer()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['billet']) &&
                isset($_POST['sujet'])) {
                mail('at.frizzy@gmail.com','Billet PONOS : '.$_POST['sujet'],$_POST['billet']);
                $view = "billet";
                $envoye = 1;
                $pagetitle = 'Billet envoyé';
            } else ControllerMain::erreur("Il manque des informations");
        }
    }
}