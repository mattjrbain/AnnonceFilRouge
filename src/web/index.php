<?php

session_start();

require_once dirname(__DIR__) . "/../vendor/autoload.php";

use Main\controllers\Main;
use Main\controllers\MyDIContainer;

// Utilisation controller
$container = new MyDIContainer();
$controller = new Main($container);
if (!empty($_GET) || !empty($_POST)) {
    try {
        $controller->parseUrl();
    } catch (Exception $e) {
        var_dump($e);
    }
} else {
    $controller->accueil();
}
