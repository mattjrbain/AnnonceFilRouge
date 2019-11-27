<?php


namespace Main\controllers;


use Main\DAO\DAO;
use Main\DAO\DAOException;
use Main\DAO\MySQLRubriqueDAO;
use Main\DAO\MySQLUtilisateurDAO;
use Main\Domain\Rubrique;
use Main\Domain\Utilisateur;
use Main\view\VueAjouterRubrique;
use Main\view\VueIdentifierUtilisateur;
use Main\view\VueListerRubriques;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class Main
{
    /**
     * @var mixed
     */
    private $actionGet;
    /**
     * @var mixed
     */
    private $actionPost;
    /**
     * @var Environment
     */
    private $twig;

    /**
     * Main constructor.
     */
    public function __construct()
    {
        //$this->request = $request;
        if (!empty($_GET['action'])){
            $this->actionGet = $_GET['action'];
        }elseif (!empty($_POST['action'])){
            $this->actionPost = $_POST['action'];
        }
        $loader = new FilesystemLoader(__DIR__."/../view");
        $this->twig = new Environment($loader, [
            'cache' => __DIR__."/../view/cache"
        ]);
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
                case "identifierUtilisateur";
                    $this->identifierUtilisateur();
                    break;
                case "testTwig";
                    $this->testTwig();
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

    private function testTwig()
    {
        try {
            echo $this->twig->render('accueil.html.twig');
        }
        catch (LoaderError $e) {
        }
        catch (RuntimeError $e) {
        }
        catch (SyntaxError $e) {
        }
    }

    private function identifierUtilisateur()
    {
        if (isset($_POST) && !empty($_POST)){
            $userDAO = new MySQLUtilisateurDAO();
            $user = new Utilisateur($_POST['name'], $_POST['pass']);
            try {
                $userDAO->identifier($user);
            }
            catch (DAOException $e) {
                echo $e->getMessage();
            }
        }else{
            $view = new VueIdentifierUtilisateur();
            $view->show();
        }
    }
}