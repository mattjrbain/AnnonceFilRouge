<?php


namespace Main\controllers;


use Main\DAO\DAO;

class Main
{

    /**
     * Main constructor.
     */
    public function __construct()
    {
    }

    public function parseUrl()
    {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case "afficherRubriques";
                    return $this->showRubriquesAction();
                    break;
                default :
                    return "Page inexistante";
            }
        }
    }

    public function showRubriquesAction()
    {
        $rubs = DAO::get('Rubrique')->getAll();
        return $rubs;
    }
}