<?php


namespace Main\controllers;


use Main\DAO\DAO;
use Main\DAO\DAOException;
use Main\DAO\MySQLAnnonceDAO;
use Main\DAO\MySQLRubriqueDAO;
use Main\DAO\MySQLUtilisateurDAO;
use Main\Domain\Annonce;
use Main\Domain\Rubrique;
use Main\Domain\Utilisateur;
use Main\view\VueAjouterRubrique;
use Main\view\VueIdentifierUtilisateur;
use Main\view\VueListerRubriques;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
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
     * @var mixed
     */
    private $param;
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
        if (!empty($_GET['action'])) {
            $this->actionGet = $_GET['action'];
        } elseif (!empty($_POST['action'])) {
            $this->actionPost = $_POST['action'];
        }
        if (!empty($_GET['param'])) {
            $this->param = $_GET['param'];
        }
        $loader     = new FilesystemLoader(dirname(__DIR__) . "\\view");
        $this->twig = new Environment(
            $loader, [
            'debug' => true
            /*'cache' => __DIR__ . "/../view/cache"*/
        ]);
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
//        $this->twig->addFunction('asset');
    }

//TODO: remettre cache après test

    public function parseUrl()
    {
        if (!empty($this->actionGet)) {
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
                case "accueil";
                    $this->accueil();
                    break;
                case "annonces";
                    $this->annoncesByRub($this->param);
                    break;
                case "connection";
                    $this->connection();
                    break;
                case "logoff";
                    $this->logoff();
                    break;
                case "signup";
                    $this->render('signup.html.twig', ['session' => $_SESSION]);
                    break;
                case "annonceUnique";
                    $this->annonceUnique();
                    break;
                case "annoncesPublisher";
                    $this->annoncesPublisher();
                    break;
                case "ajouterAnnonce";
                    $this->ajoutAnnonce();
                    break;
                case "submitAnnonce";
                    $this->submitAnnonce();
                    break;
                case "modifierAnnonce";
                    $this->modifierAnnonce();
                    break;
                case "updateAnnonce";
                    $this->updateAnnonce();
                    break;
                case "supprimerAnnonce";
                    $this->supprimerAnnonce();
                    break;
                case "createAccount";
                    $this->createAccount();
                    break;
                default :
                    echo "Page inexistante";
            }
        } else $this->accueil();
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
        if (isset($_POST) && !empty($_POST)) {
            $rubDao = new MySQLRubriqueDAO();
            $rub    = new Rubrique($_POST['libelle']);
            try {
                $rubDao->insert($rub);
            }
            catch (DAOException $e) {
                echo $e->getMessage();
            }
        } else {
            $view = new VueAjouterRubrique();
            $view->show();
        }
    }

    private function identifierUtilisateur()
    {
        if (isset($_POST) && !empty($_POST)) {
            $userDAO = new MySQLUtilisateurDAO();
            $user    = new Utilisateur($_POST['name'], $_POST['pass']);
            try {
                $userDAO->identifier($user);
            }
            catch (DAOException $e) {
//                $_SESSION['errorPass'] = "Mauvais mot de passe";
//                header('Location: ?action=connection');
                $this->render('connection.html.twig', ['session' => $_SESSION, "errorPass" => true]);
            }
        } else {
            $view = new VueIdentifierUtilisateur();
            $view->show();
        }
    }

    public function render($filename, $data = [])
    {
        try {
            $view = $this->twig->load($filename);
            echo $view->render($data);
        }
        catch (LoaderError $e) {
            echo $e->getMessage();
        }
        catch (RuntimeError $e) {
            echo $e->getMessage();

        }
        catch (SyntaxError $e) {
            echo $e->getMessage();

        }
    }

    public function accueil()
    {
        $rubs = DAO::get('Rubrique')->getAll();
        $this->render('accueil.html.twig', ['session' => $_SESSION, "rubs" => $rubs]);
    }

    public function annoncesByRub($rubrique)
    {
        //$annonces = DAO::get('Annonce')->getByRub($rubrique);
        $annoncesDAO = new MySQLAnnonceDAO();
        try {
            $rub      = DAO::get('Rubrique')->getByName($rubrique);
            $annonces = $annoncesDAO->getByRub($rub);
            $this->render('listeAnnoncesVisiteur.html.twig', ['session' => $_SESSION, "annonces" => $annonces]);
        }
        catch (DAOException $e) {
            echo $e->getMessage();
        }
    }

    private function connection()
    {
        //unset($_SESSION['errorPass']);

        if (isset($_POST) && !empty($_POST)) {
            $userDAO = new MySQLUtilisateurDAO();
            $user    = new Utilisateur($_POST['name'], $_POST['pass']);
            try {
                $userDAO->identifier($user);
                header('Location: ?action=connection');
            }
            catch (DAOException $e) {
                $this->render('connection.html.twig', ['session' => $_SESSION, 'errorPass' => true]);
            }
        } else {
            $this->render('connection.html.twig', ['session' => $_SESSION, '']);
        }
    }

    private function logoff()
    {
        session_destroy();
        header('Location: ?action=connection');
    }

    private function annonceUnique()
    {
        $annonce = DAO::get('Annonce')->getById($this->param);
        $this->render('annonceUnique.html.twig', ['session' => $_SESSION, 'annonce' => $annonce]);
    }

    private function annoncesPublisher()
    {
        $user     = DAO::get('Utilisateur')->getByName($this->param);
        $annonces = DAO::get('Annonce')->getByUser($user);
        $this->render('listeAnnoncesPublisher.html.twig', ['session' => $_SESSION, 'annonces' => $annonces]);
    }

    private function ajoutAnnonce()
    {
        $rubs = DAO::get('Rubrique')->getAll();
        $this->render("ajoutAnnonce.html.twig", ['session' => $_SESSION, 'rubs' => $rubs]);
    }

    private function submitAnnonce()
    {
        $user       = DAO::get('Utilisateur')->getByName($this->param);
        $rub        = DAO::get('Rubrique')->getByName($_POST['rubrique']);
        $img = $this->upload();
        $annonce    = new Annonce($user, $rub, $_POST['entete'], $_POST['corps'], $img);
        $retAnnonce = DAO::get('Annonce')->insert($annonce);
        $this->render("annonceUnique.html.twig", ['session' => $_SESSION, 'annonce' => $retAnnonce]);
        //print_r($_POST);
    }

    private function modifierAnnonce()
    {
        $annonce = DAO::get('Annonce')->getById($this->param);
        $rubs    = DAO::get('Rubrique')->getAll();
        $this->render(
            'modifierAnnonce.html.twig', [
            'session' => $_SESSION,
            'annonce' => $annonce,
            'rubs'    => $rubs
        ]);
    }

    private function updateAnnonce()
    {
        try {
            $annonceDAO = new MySQLAnnonceDAO();
            $annonce    = $annonceDAO->getById($this->param);
            $rubrique   = DAO::get('Rubrique')->getByName($_POST['rubrique']);
            $annonce->setRubrique($rubrique);
            $annonce->setEntete($_POST['entete']);
            $annonce->setCorps($_POST['corps']);
            $annonce->setDateLimite($_POST['dateLimite']);
            $annonceDAO->update($annonce);
            $this->render(
                "annonceUnique.html.twig", [
                'session' => $_SESSION,
                'annonce' => $annonce,
                'message' => "L'annonce a bien été modifiée.",
                'type'    => 'success'
            ]);
        }
        catch (DAOException $e) {
            //TODO: set error page
            //TODO: set message "Annonce modifiée avec succès"
            echo $e->getMessage();
        }

    }

    private function supprimerAnnonce()
    {
        $annonceDAO = new MySQLAnnonceDAO();
        try {
            $annonce = $annonceDAO->getById($this->param);
            $annonceDAO->delete($annonce);
            $user     = DAO::get('Utilisateur')->getByName($_SESSION['user']);
            $annonces = DAO::get('Annonce')->getByUser($user);
            $this->render(
                "listeAnnoncesPublisher.html.twig", [
                'session'  => $_SESSION,
                'annonces' => $annonces,
                'message'  => "L'annonce a bien été supprimée.",
                'type'     => 'success'
            ]);
        } catch (DAOException $e) {
            $user     = DAO::get('Utilisateur')->getByName($_SESSION['user']);
            $annonces = DAO::get('Annonce')->getByUser($user);
            $this->render(
                "listeAnnoncesPublisher.html.twig", [
                'session'  => $_SESSION,
                'annonces' => $annonces,
                'message'  => "Un problème est survenu. L'annonce n'a pas été supprimée.",
                'type'     => 'danger'
            ]);
        }
    }

    private function createAccount()
    {
        $user    = new Utilisateur($_POST['nom'], $_POST['password'], $_POST['mail']);
        $userDAO = new MySQLUtilisateurDAO();
        try {
            $userDAO->insert($user);
            $this->render(
                'signup.html.twig', [
                'message' => 'Bienvenue, ' . $_POST['nom'] . ', votre compte est bien crée.' . "\n" . ' Vous pouvez vous connecter.',
                'type'    => 'success'
            ]);
        }
        catch (DAOException $e) {
            $this->render(
                'signup.html.twig', [
                'message' => 'Le nom "' . $_POST['nom'] . '" est déjà utilisé.',
                'type'    => 'warning'
            ]);
        }
    }

    public function showRubriquesAction()
    {
        return DAO::get('Rubrique')->getAll();
    }

    /**
     * @return string
     */
    private function upload()
    {
        // Source : OpenClassrooms
        // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
        if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0) {
            // Testons si le fichier n'est pas trop gros
            if ($_FILES['photo']['size'] <= 1000000) {
                // Testons si l'extension est autorisée
                $infosfichier          = pathinfo($_FILES['photo']['name']);
                $extension_upload      = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees)) {
                    // On peut valider le fichier et le stocker définitivement
                    move_uploaded_file($_FILES['photo']['tmp_name'], 'img/' . basename($_FILES['photo']['name']));
//                    echo "L'envoi a bien été effectué !";
                    return 'img/' . basename($_FILES['photo']['name']);
                }
            }
        }
        return null;

    }
}