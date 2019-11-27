<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\ArrayLoader;
use Twig\Loader\FilesystemLoader;

require_once dirname(__DIR__) . "/../vendor/autoload.php";


$loader = new FilesystemLoader(__DIR__);
$twig = new Environment($loader, []);

try {
    echo $twig->render('accueil.html.twig'/*, ['name' => 'Fabien']*/);
}
catch (LoaderError $e) {
}
catch (RuntimeError $e) {
}
catch (SyntaxError $e) {
}