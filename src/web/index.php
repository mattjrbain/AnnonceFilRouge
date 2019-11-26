<?php

require_once dirname(__DIR__)."/../vendor/autoload.php";

use Main\controllers\Main;
use Main\view\VueAccueil;

//echo $_SERVER['PHP_SELF'];
//print_r($_GET);
$vue = new VueAccueil();

$linkList = $vue->show();

foreach ($linkList as $item) {
    echo($item);
}

if ((isset($_GET['action']) && !is_null($_GET['action'])) || isset($_POST)){
    $controller = new Main();
//    print_r($controller->parseUrl());
    $controller->parseUrl();

}
