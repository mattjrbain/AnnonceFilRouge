<?php

session_start();

require_once dirname(__DIR__)."/../vendor/autoload.php";

use Main\controllers\Main;
use Main\view\VueAccueil;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


// Affichage "menu"
$vue = new VueAccueil();
$linkList = $vue->show();
foreach ($linkList as $item) {
    echo($item);
}

// Utilisation controller
if (!empty($_GET) || !empty($_POST)){
    $controller = new Main();
    $controller->parseUrl();
}
