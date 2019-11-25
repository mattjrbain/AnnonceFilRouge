<?php

require_once dirname(__DIR__)."/vendor/autoload.php";


use Main\DAO\DAOException;
use Main\DAO\MySQLRubriqueDAO;
use Main\view\VueAccueil;

$rubDAO = new MySQLRubriqueDAO();

//try {
//    $rubs = $rubDAO->getAll();
//    foreach ($rubs as $rub) {
//        print_r($rub);
//    }
//}
//catch (DAOException $e) {
//}



