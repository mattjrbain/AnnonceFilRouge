<?php

//echo dirname(__DIR__);
// require_once "../vendor/autoload.php";
require_once dirname(__DIR__)."/vendor/autoload.php";
use Main\DAO\DAO;
use Main\DAO\DAOException;
use Main\DAO\MySQLAnnonceDAO;
use Main\DAO\MySQLRubriqueDAO;
use Main\DAO\MySQLUtilisateurDAO;
use Main\Domain\Annonce;
use Main\Domain\Rubrique;
use Main\Domain\Utilisateur;

$annonceDAO = new MySQLAnnonceDAO();
$rubriqueDAO = new MySQLRubriqueDAO();
$userDAO = new MySQLUtilisateurDAO();


try {
    //var_dump(DAO::get('Utilisateur'));
    //Creation user
//    $user = $userDAO->getByName("Nono");

    //Creation rubrique
//    $rub = $rubriqueDAO->getByName("grillepain");

    //Creation annonce
//    $annonce = new Annonce($user,$rub,"test mardi 2", "corps test mardi");

    //Insertion
//    print_r($annonceDAO->insert($annonce));

    //Update
//    $annonce = $annonceDAO->getById(20);
//    $annonce->setUser($user);
//    echo($annonceDAO->update($annonce));

    //Get by Rubrique
//    $rub = $rubriqueDAO->getByName("grillepain");
//    $annonces = $annonceDAO->getByRub($rub);
//    print_r($annonces);

    //Get by User
    $user = $userDAO->getById(16);
    $annonces = $annonceDAO->getByUser($user);
    print_r($annonces);

    //Delete
//    $annonce = $annonceDAO->getById(11);
//    echo($annonceDAO->delete($annonce));

    //Delete perimées
//    echo $annonceDAO->deletePerimees();

    //Rubrique//////
    //Insert
//    $rub = new Rubrique("grillepain");
//    print_r($rubriqueDAO->insert($rub));

    //Delete
//    $rub = $rubriqueDAO->getByName("sexe");
//    echo $rubriqueDAO->delete($rub);

    //Update
//    $rub = $rubriqueDAO->getByName("encore autre chose");
//    $rub->setLibelle("enclumes");
//    echo $rubriqueDAO->update($rub);

    //Get all
//    print_r($rubriqueDAO->getAll());

    //User///////
    //Insert
//    $user = new Utilisateur("Nono","Nono");
//    print_r($userDAO->insert($user));

    //Identifier
//    $user = new Utilisateur("Non", "Nono");
//    print_r($userDAO->identifier($user));
}
catch (DAOException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
} catch (Error $error){
    echo $error->getMessage();
}

