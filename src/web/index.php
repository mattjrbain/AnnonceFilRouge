<?php

require_once dirname(__DIR__)."/../vendor/autoload.php";

use Main\controllers\Main;
use Main\controllers\Request;
use Main\view\VueAccueil;

// Affichage "menu"
$vue = new VueAccueil();
$linkList = $vue->show();
foreach ($linkList as $item) {
    echo($item);
}

// Utilisation controller
if (!empty($_GET) || !empty($_POST)){
    $controller = new Main(new Request());
    $controller->parseUrl();

}
