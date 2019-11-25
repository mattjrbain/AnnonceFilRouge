<?php

require_once dirname(__DIR__)."/../vendor/autoload.php";

use Main\controllers\Main;
use Main\view\VueAccueil;

//echo "Coucou";
//print_r($_GET);
$vue = new VueAccueil();

$linkList = $vue->show();

foreach ($linkList as $item) {
    echo($item);
}

if (isset($_GET) && !is_null($_GET)){
    $controller = new Main();
//    print_r($controller->parseUrl());
    $rubs = $controller->parseUrl();
    foreach ( $rubs as $item) {
        print_r($item);
    }
}
