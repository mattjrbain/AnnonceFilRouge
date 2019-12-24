<?php

session_start();

require_once dirname(__DIR__) . "/../vendor/autoload.php";

use Main\controllers\Main;

// Utilisation controller
$controller = new Main();
if (!empty($_GET) || !empty($_POST)) {
    try {
        $controller->parseUrl();
    } catch (Exception $e) {
        var_dump($e);
    }
} else {
    $controller->accueil();
}
