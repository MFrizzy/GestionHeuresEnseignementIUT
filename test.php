<?php
/**
 * Created by PhpStorm.
 * User: mfrizzy
 * Date: 24/12/17
 * Time: 15:23
 */

require_once 'lib/Security.php';

//echo Security::chiffrer("root");


$a = 'MID3322';

echo $a;
$a = substr($a,3);
echo '<br>'.$a;
echo '<br>'.substr($a,2);
