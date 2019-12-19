<?php


namespace Main\controllers;


use DateInterval;
use DateTime;
use Exception;
use Main\DAO\DAO;
use Main\DAO\DAOException;
use Main\DAO\MySQLAnnonceDAO;
use Main\DAO\MySQLImageDAO;
use Main\DAO\MySQLRubriqueDAO;
use Main\DAO\MySQLUtilisateurDAO;
use Main\Domain\Annonce;
use Main\Domain\Image;
use Main\Domain\Rubrique;
use Main\Domain\Utilisateur;

//use Main\view\VueAjouterRubrique;
//use Main\view\VueIdentifierUtilisateur;
//use Main\view\VueListerRubriques;
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

    /**
     * Parses actionGet variable and calls corresponding function
     * @throws Exception
     */
    public function parseUrl()
    {
        if (!empty($this->actionGet)) {
            switch ($this->actionGet) {
//                case "afficherRubriques";
//                    $this->afficherRubriques();
//                    break;
                case "ajouterRubrique";
                    $this->ajouterRubrique();
                    break;
//                case "identifierUtilisateur";
//                    $this->identifierUtilisateur();
//                    break;
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
                case "supprimerImage";
                    $this->supprimerImage();
                    break;
                case "admin";
                    $this->admin();
                    break;
                case "deleteRub";
                    $this->deleteRub();
                    break;
                case "updateRub";
                    $this->updateRub();
                    break;
                case "confirm";
                    $this->confirm();
                    break;
                default :
                    echo "Page inexistante";
            }
        } else $this->accueil();
    }

//    /**
//     *
//     */
//    public function afficherRubriques()
//    {
//        $rubs = DAO::get('Rubrique')->getAll();
//        $view = new VueListerRubriques();
//        $view->setContenu($rubs);
//        $view->show();
//    }
//

//    private function identifierUtilisateur()
//    {
//        if (isset($_POST) && !empty($_POST)) {
//            $userDAO = new MySQLUtilisateurDAO();
//            $user    = new Utilisateur($_POST['name'], $_POST['pass']);
//            try {
//                $userDAO->identifier($user);
//            }
//            catch (DAOException $e) {
////                $_SESSION['errorPass'] = "Mauvais mot de passe";
////                header('Location: ?action=connection');
//                $this->render('connection.html.twig', [/*'session' => $_SESSION, */"errorPass" => true]);
//            }
//        } else {
//            $view = new VueIdentifierUtilisateur();
//            $view->show();
//        }
//    }

    private function ajouterRubrique()
    {
        if (isset($_SESSION['isAdmin'])) {
            if (isset($_POST) && !empty($_POST)) {
                $rubDao  = new MySQLRubriqueDAO();
                $userDAO = new MySQLUtilisateurDAO();
                $rub     = new Rubrique($_POST['libelle']);
                try {
                    $rubDao->insert($rub);
                    $rubriques = $rubDao->getAll();
                    $users     = $userDAO->getAll();
                    $this->render(
                        'admin.html.twig', [
                        'message'   => 'Votre rubrique a bien ajoutée !',
                        'type'      => 'success',
                        'rubriques' => $rubriques,
                        'users'     => $users
                    ]);
                }
                catch (DAOException $e) {
                    $this->render('404.html.twig', ['message' => $e->getMessage()]);
                }
            } else {
                $this->render(
                    'admin.html.twig', [
                    'message' => 'C\'était vide ! '
                ]);
            }
        } else {
            $this->render('404.html.twig', ['message' => 'Vous devez être administrateur pour allez ici >:(']);
        }
    }

    /**
     * @param $filename
     * @param array $data
     */
    public function render($filename, $data = [])
    {
        try {
            $view = $this->twig->load($filename);
            echo $view->render($data);
        }
        catch (LoaderError $e) {
            $this->render('404.html.twig', ['message' => $e->getMessage()]);
        }
        catch (RuntimeError $e) {
            $this->render('404.html.twig', ['message' => $e->getMessage()]);

        }
        catch (SyntaxError $e) {
            $this->render('404.html.twig', ['message' => $e->getMessage()]);

        }
    }

    /**
     * Calls welcome page
     */
    public function accueil()
    {
        $rubs = DAO::get('Rubrique')->getAll();
        $this->render('accueil.html.twig', ["rubs" => $rubs]);
    }

    /**
     * @param $rubrique
     * @throws Exception
     */
    public function annoncesByRub($rubrique)
    {
        //$annonces = DAO::get('Annonce')->getByRub($rubrique);
        $annoncesDAO = new MySQLAnnonceDAO();
        try {
            $rub      = DAO::get('Rubrique')->getByName($rubrique);
            $annonces = $annoncesDAO->getByRub($rub);
            $this->render('listeAnnoncesVisiteur.html.twig', ["annonces" => $annonces, "rub" => $rubrique]);
        }
        catch (DAOException $e) {
            $this->render('404.html.twig', ['message' => $e->getMessage()]);
        }
    }

    /**
     *
     * @throws Exception
     */
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
                $this->render('connection.html.twig', [/*'session' => $_SESSION, */ 'errorPass' => true, 'message' => $e->getMessage()]);
            }
        } else {
            $this->render('connection.html.twig', [/*'session' => $_SESSION, */ '']);
        }
    }

    /**
     *
     */
    private function logoff()
    {
        session_destroy();
        header('Location: ?action=connection');
    }

    /**
     * @throws Exception
     */
    private function annonceUnique()
    {
        $annonceDAO = new MySQLAnnonceDAO();
        try {
            $annonce = $annonceDAO->getById($this->param);
            $annonceDAO->updateVisite($annonce);
            $this->render('annonceUnique.html.twig', [/*'session' => $_SESSION, */ 'annonce' => $annonce]);
        }
        catch (DAOException $e) {
            $this->render('404.html.twig', ['message' => $e->getMessage()]);
        }
    }

    private function annoncesPublisher()
    {
        $user     = DAO::get('Utilisateur')->getByName($this->param);
        $annonces = DAO::get('Annonce')->getByUser($user);
        $this->render('listeAnnoncesPublisher.html.twig', [/*'session' => $_SESSION, */ 'annonces' => $annonces]);
    }

    private function ajoutAnnonce()
    {
        $rubs = DAO::get('Rubrique')->getAll();
        $this->render("ajoutAnnonce.html.twig", [/*'session' => $_SESSION, */ 'rubs' => $rubs]);
    }

    private function submitAnnonce()
    {
        $user = DAO::get('Utilisateur')->getByName($this->param);
//        $userDAO = new MySQLUtilisateurDAO();
//        $user = $userDAO->getByName($this->param);
        $rub     = DAO::get('Rubrique')->getByName($_POST['rubrique']);
        $annonce = new Annonce($user, $rub, $_POST['entete'], $_POST['corps']);
//        $retAnnonce = DAO::get('Annonce')->insert($annonce);
        $annonceDAO = new MySQLAnnonceDAO();
        try {
            $retAnnonce = $annonceDAO->insert($annonce);
            $img        = $this->upload($retAnnonce->getAnnonceId());
            $retAnnonce->setImages($img);
//            var_dump($retAnnonce);
            $this->render(
                "annonceUnique.html.twig", [
                'session' => $_SESSION,
                'annonce' => $retAnnonce,
                'message' => 'Votre annonce a bien été enregistrée !',
                'type'    => 'success'
            ]);
        }
        catch (DAOException $e) {
            $this->render('404.html.twig', ['message' => $e->getMessage()]);
        }
        //print_r($_POST);
    }

    /**
     * @param $annonceId
     * @return array
     * @throws DAOException
     */
    private function upload($annonceId)
    {
        $pictures = array();
        // Source : OpenClassrooms
        // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
        for ($i = 0; $i < count($_FILES); $i++) {
            if (isset($_FILES['photo' . $i]) AND $_FILES['photo' . $i]['error'] == 0) {
                // Testons si le fichier n'est pas trop gros
                if ($_FILES['photo' . $i]['size'] <= 1000000) {
                    // Testons si l'extension est autorisée
                    $infosfichier          = pathinfo($_FILES['photo' . $i]['name']);
                    $extension_upload      = $infosfichier['extension'];
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                    if (in_array($extension_upload, $extensions_autorisees)) {
                        // On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($_FILES['photo' . $i]['tmp_name'], 'img/' . basename($_FILES['photo' . $i]['name']));
                        //                    echo "L'envoi a bien été effectué !";
//                        return 'img/' . basename($_FILES['photo'. $i]['name']);
                        $pictures[] = new Image('img/' . basename($_FILES['photo' . $i]['name']), $annonceId);
                    }
                }
            }
        }
        $imgDAO = new MySQLImageDAO();
        foreach ($pictures as $picture) {
            $imgDAO->insert($picture);
        }
        return $pictures;

    }

    private function modifierAnnonce()
    {
        $annonce = DAO::get('Annonce')->getById($this->param);
        $rubs    = DAO::get('Rubrique')->getAll();
        $images  = DAO::get('Image')->getByAnnonce($annonce);
        $this->render(
            'modifierAnnonce.html.twig', [
            'session' => $_SESSION,
            'annonce' => $annonce,
            'rubs'    => $rubs,
            'images'  => $images
        ]);
    }

    private function updateAnnonce()
    {
        try {
            $annonceDAO = new MySQLAnnonceDAO();
            $imageDAO   = new MySQLImageDAO();
            $annonce    = $annonceDAO->getById($this->param);
            $rubrique   = DAO::get('Rubrique')->getByName($_POST['rubrique']);
            $annonce->setRubrique($rubrique);
            $annonce->setEntete($_POST['entete']);
            $annonce->setCorps($_POST['corps']);
            $annonce->setDateLimite($_POST['dateLimite']);
            $annonceDAO->update($annonce);
            $this->upload($this->param);
            $imgs = $imageDAO->getByAnnonce($annonce);
            $annonce->setImages($imgs);
            $this->render(
                "annonceUnique.html.twig", [
                'session' => $_SESSION,
                'annonce' => $annonce,
                'message' => "L'annonce a bien été modifiée.",
                'type'    => 'success'
            ]);
        }
        catch (Exception $e) {
            //TODO: set error page
            //TODO: set message "Annonce modifiée avec succès"
            $this->render('404.html.twig', ['message' => $e->getMessage()]);
        }

    }

    private function supprimerAnnonce()
    {
        $annonceDAO = new MySQLAnnonceDAO();
        try {
            $annonce = $annonceDAO->getById($this->param);
            if ($annonce->getUser()->getNom() == isset($_SESSION['user'])) {
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

            } else {
                $this->render('404.html.twig', ['message' => 'Vous devez être le détenteur de cette annonce pour la modifier.']);
            }
        }
        catch (DAOException $e) {
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
        $confirmation_token = uniqid();
        $user               = new Utilisateur($_POST['nom'], $_POST['password'], $_POST['mail'], $confirmation_token);
        $userDAO            = new MySQLUtilisateurDAO();
        try {
            $inserted = $userDAO->insert($user);
            $userId = $inserted->getUserId();
            $link     = "<a href=\"http://annoncesfilrouge/?action=confirm&param=$confirmation_token&userId=$userId\">ce lien</a>";

            mail($user->getMail(), "Confirmez votre adresse", "Pour fiinaliser la création de votre compte, merci de cliquer sur $link :  ");
            $this->render(
                'signup.html.twig', [
                'message' => 'Bienvenue, ' . $_POST['nom'] . ', votre compte est bien crée.' . "\n" . ' Un mail de confirmation vous a été envoyé.',
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

    private function confirm()
    {
        $userDAO = new MySQLUtilisateurDAO();
        try {
            $user = $userDAO->getById($_GET['userId']);
            if ($this->param == $user->getConfirmationToken()){
                $confirm = new DateTime();
                $obsoleteDate = $user->getCreatedAt()->add(new DateInterval('P2D'));
//                if ($user->getConfirmedAt() > $user->getCreatedAt()->add(new DateInterval('P2D'))) {
                if ($confirm < $obsoleteDate) {
                    $user->setConfirmedAt(new DateTime());
                    $userDAO->update($user);
                    $this->render(
                        'signup.html.twig', [
                        'message' => 'Bienvenue, ' . $user->getNom() . ', votre email est bien confirmé.' . "\n" . ' Vous pouvez maintenant vous connecter.',
                        'type'    => 'success'
                    ]);
                } else {
                    $this->render('404.html.twig', ['message' => 'Ce lien est périmé.']);
                }
            }else{
                $this->render('404.html.twig', ['message' => 'Ceci n\'est pas le bon lien.']);
            }
        }
        catch (Exception $e) {
            $this->render('404.html.twig', ['message' => $e->getMessage()]);
        }

    }

    private function supprimerImage()
    {
        try {
            $imageDAO = new MySQLImageDAO();
            $image    = $imageDAO->getById($this->param);
            $imageDAO->delete($image);
            $annonce = DAO::get('Annonce')->getById($image->getAnnonceId());
            $rubs    = DAO::get('Rubrique')->getAll();
            $images  = DAO::get('Image')->getByAnnonce($annonce);
            $this->render(
                'modifierAnnonce.html.twig', [
                'session' => $_SESSION,
                'annonce' => $annonce,
                'rubs'    => $rubs,
                'images'  => $images,
                'message' => "L'image a bien été supprimée .",
                'type'    => 'success'
            ]);
        }
        catch (DAOException $e) {
            $this->render('404.html.twig', ['message' => $e->getMessage()]);

        }
    }

    private function admin()
    {
        if (isset($_SESSION['isAdmin'])) {
            $rubDAO  = new MySQLRubriqueDAO();
            $userDAO = new MySQLUtilisateurDAO();
            try {
                $rubriques = $rubDAO->getAll();
                $users     = $userDAO->getAll();
                $this->render(
                    'admin.html.twig', [
                    'rubriques' => $rubriques,
                    'users'     => $users
                ]);
            }
            catch (DAOException $e) {
                $this->render('404.html.twig', ['message' => $e->getMessage()]);
            }
        } else {
            $this->render('404.html.twig', ['message' => 'Vous devez être administrateur pour allez ici >:(']);
        }
    }

    /**
     * @throws Exception
     */
    private function deleteRub()
    {
        if (isset($_SESSION['isAdmin'])) {
            $rubDAO  = new MySQLRubriqueDAO();
            $userDAO = new MySQLUtilisateurDAO();
            try {
                $rub = $rubDAO->getById($this->param);
                $rubDAO->delete($rub);
                $rubriques = $rubDAO->getAll();
                $users     = $userDAO->getAll();
                $this->render(
                    'admin.html.twig', [
                    'rubriques' => $rubriques,
                    'users'     => $users,
                    'message'   => "La rubrique a bien été supprimée .",
                    'type'      => 'success'
                ]);
            }
            catch (Exception $e) {
                $this->render('404.html.twig', ['message' => $e->getMessage()]);
            }

        } else {
            $this->render('404.html.twig', ['message' => 'Vous devez être administrateur pour allez ici >:(']);
        }

    }

    private function updateRub()
    {
        if (isset($_SESSION['isAdmin'])) {
            $rubDAO  = new MySQLRubriqueDAO();
            $userDAO = new MySQLUtilisateurDAO();
            try {
                $users = $userDAO->getAll();
                $rub   = $rubDAO->getByName($this->param);
                $rub->setLibelle($_POST['libelle']);
                $rubDAO->update($rub);
                $rubriques = $rubDAO->getAll();
                $this->render(
                    'admin.html.twig', [
                    'rubriques' => $rubriques,
                    'users'     => $users,
                    'message'   => "La rubrique a bien été modifiée .",
                    'type'      => 'success'
                ]);
            }
            catch (DAOException $e) {
                $this->render('404.html.twig', ['message' => $e->getMessage()]);
            }

        } else {
            $this->render('404.html.twig', ['message' => 'Vous devez être administrateur pour allez ici >:(']);
        }
    }



    public function showRubriquesAction()
    {
        return DAO::get('Rubrique')->getAll();
    }


}