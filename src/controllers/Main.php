<?php


namespace Main\controllers;


use Main\DAO\DAO;
use Main\DAO\DAOException;
use Main\DAO\MySQLRubriqueDAO;
use Main\Domain\Rubrique;
use Main\view\VueAjouterRubrique;
use Main\view\VueListerRubriques;

class Main
{
    private $actionGet;
    private $actionPost;
    /**
     * Main constructor.
     */
    public function __construct()
    {
        if (!empty($_GET['action'])){
            $this->actionGet = $_GET['action'];
        }elseif (!empty($_POST['action'])){
            $this->actionPost = $_POST['action'];
        }
    }

    public function parseUrl()
    {
        if (isset($this->actionGet)) {
            switch ($this->actionGet) {
                case "afficherRubriques";
                    $this->afficherRubriques();
                    break;
                case "ajouterRubrique";
                    $this->ajouterRubrique();
                    break;
                default :
                    echo "Page inexistante";
            }
        }
    }

    public function showRubriquesAction()
    {
        $rubs = DAO::get('Rubrique')->getAll();
        return $rubs;
    }

    public function afficherRubriques()
    {
        $rubs = DAO::get('Rubrique')->getAll();
        $view = new VueListerRubriques();
        $view->setContenu($rubs);
        $view->show();
    }

    private function ajouterRubrique()
    {
        if (isset($_POST) && !empty($_POST)){
            $rubDao = new MySQLRubriqueDAO();
            $rub= new Rubrique($_POST['libelle']);
            var_dump($rub);
            try {
               $rubDao->insert($rub);
            }
            catch (DAOException $e) {
                echo $e->getMessage();
            }
        }else{
            $view = new VueAjouterRubrique();
            $view->show();
        }
    }
}