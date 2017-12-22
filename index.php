<?php
/**
 * Created by PhpStorm.
 * User: tangu
 * Date: 06/10/2017
 * Time: 12:06
 */

session_start();

require_once (__DIR__.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'File.php');
require_once (File::build_path(array('controller','routeur.php')));