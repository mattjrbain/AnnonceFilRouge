<?php

session_start();

require_once dirname(__DIR__)."/../vendor/autoload.php";

use Main\controllers\Main;
use Main\view\VueAccueil;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

//$loader = new FilesystemLoader(__DIR__."/../view");
//$twig = new Environment($loader, [
//    'cache' => __DIR__."/../view"
//]);

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
