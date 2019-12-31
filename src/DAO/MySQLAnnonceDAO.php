<?php


namespace Main\DAO;


use DateInterval;
use DateTime;
use DateTimeZone;
use Exception;
use Main\Domain\Annonce;
use Main\Domain\Entity;
use Main\Domain\Rubrique;
use Main\Domain\Utilisateur;
use PDO;

class MySQLAnnonceDAO extends DAO implements CrudInterface
{
    CONST VALIDITE_MAX     = '28 DAY';
    CONST VALIDITE_MAX_PHP = 28;

    /**
     * @var MySQLUtilisateurDAO
     */
    private $userDAO;
    /**
     * @var MySQLRubriqueDAO
     */
    private $rubDAO;

    /**
     * MySQLAnnonceDAO constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->userDAO = new MySQLUtilisateurDAO();
        $this->rubDAO  = new MySQLRubriqueDAO();

    }

    /**
     * @return MySQLUtilisateurDAO
     */
    public function getUserDAO(): MySQLUtilisateurDAO
    {
        return $this->userDAO;
    }

    /**
     * @return MySQLRubriqueDAO
     */
    public function getRubDAO(): MySQLRubriqueDAO
    {
        return $this->rubDAO;
    }


    /**
     * @param Entity $annonce
     * @return Annonce|null
     * @throws DAOException
     */
    public function insert(Entity $annonce)
    {
        try {
            $this->getCnx()
                 ->beginTransaction();
            $stmt     = $this->getCnx()
                             ->prepare(
                                 'INSERT INTO annonce (user_id, rubrique_id, en_tete, corps, date_creation, date_modif, date_limite) 
                                                            VALUES (:user_id, :rubrique_id, :en_tete, :corps, :date_creation, :date_modif, :date_limite)');
            $now      = new DateTime();
            $nowclone = clone $now;
            $limite   = $nowclone->add(new DateInterval('P' . self::VALIDITE_MAX_PHP . 'D'));
            $now->setTimezone(new DateTimeZone(self::TIMEZONE));
            $stmt->bindValue(
                ':user_id', $annonce->getUser()->getUserId(), PDO::PARAM_INT);
            $stmt->bindValue(
                ':rubrique_id', $annonce->getRubrique()->getRubriqueId(), PDO::PARAM_INT);
            $stmt->bindValue(':en_tete', $annonce->getEnTete());
            $stmt->bindValue(':corps', $annonce->getCorps());
            $stmt->bindValue(':date_creation', $now->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':date_modif', $now->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':date_limite', $limite->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->execute();
            $lastId = $this->getCnx()
                           ->lastInsertId();
            $this->getCnx()
                 ->commit();
//            return $lastId;
            return $this->getById($lastId);
        } catch (Exception $e) {
//            echo $e->getMessage() . "\n";
//            echo (int)$e->getCode() . "\n";
            $this->getCnx()
                 ->rollBack();
            throw new DAOException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws DAOException
     */
    public function getById(int $id)
    {
        try {
            $this->getCnx()
                 ->beginTransaction();
//            $stmt = $this->getCnx()->prepare('SELECT * FROM annonce WHERE annonce_id = :id');
            $stmt = $this->getCnx()
                         ->prepare(
                             'SELECT a.annonce_id as a_id, a.en_tete, a.corps, a.date_creation as crea, 
                                                        a.date_modif as modif, a.date_limite as dlimit, a.visites as visit,
                                                        group_concat(image_src) AS images,
                                                        u.user_id, nom, mot_de_passe as mdp, mail, est_admin, confirmation_token, created_at,
                                                        r.rubrique_id as r_id, libelle
                                                FROM annonce AS a
                                                INNER JOIN image i ON a.annonce_id = i.annonce_id
                                                INNER JOIN utilisateur u ON a.user_id = u.user_id
                                                INNER JOIN rubrique r ON a.rubrique_id = r.rubrique_id
                                                WHERE a.annonce_id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->getCnx()
                 ->commit();
            return $this->annonceFromArray($data);
        } catch (Exception $e) {
            $this->getCnx()
                 ->rollBack();
            throw new DAOException($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @return Annonce
     */
    public function annonceFromArray(array $data)
    {
        //todo: à modifier quand tous les users sont crées correctement
//        $created_at = DateTime::createFromFormat('Y-m-d H:i:s', $data['created_at']) ?? null;
        $created_at = $data['created_at'] ? DateTime::createFromFormat('Y-m-d H:i:s', $data['created_at']) : null;
//        $confirmed_at = $data['confirmed_at'] ? DateTime::createFromFormat('Y-m-d H:i:s', $data['confirmed_at']) : null;
        $user     = new Utilisateur($data['nom'], $data['mdp'], $data['mail'], $data['confirmation_token'], $created_at, $data['est_admin'], $data['user_id']/*, $confirmed_at*/);
        $rub      = new Rubrique($data['libelle'], $data['r_id']);
        $imgs     = explode(',', $data['images']);
        $dateCrea = DateTime::createFromFormat('Y-m-d H:i:s', $data['crea']);
        $annonce  = new Annonce($user, $rub, $data['en_tete'], $data['corps'], $imgs, $data['visit'], $dateCrea, $data['a_id']);
        $annonce->setDateLimite($data['dlimit']);
        $annonce->setDateModif($data['modif']);
        return $annonce;
    }

    /**
     * @param Entity $annonce
     * @return int rowcount
     * @throws DAOException
     */
    public function delete(Entity $annonce)
    {
        try {
            $this->getCnx()
                 ->beginTransaction();
            $stmt = $this->getCnx()
                         ->prepare('DELETE FROM annonce WHERE annonce_id = :id');
            $stmt->bindValue(':id', $annonce->getAnnonceId());
            $stmt->execute();
            $count = $stmt->rowCount();
            $this->getCnx()
                 ->commit();
            return $count;

        } catch (Exception $e) {
//            echo $e->getMessage() . "\n";
//            echo (int)$e->getCode() . "\n";
            $this->getCnx()
                 ->rollBack();
            throw new DAOException($e->getMessage());
        }
    }

    /**
     * @param Annonce $entity
     * @return int
     * @throws DAOException
     */
    public function update(Annonce $entity)//$id, $entete, $corps
    {
        try {
            $this->getCnx()
                 ->beginTransaction();
            $stmt = $this->getCnx()
                         ->prepare(
                             'UPDATE annonce
                                        SET rubrique_id = :rubrique_id,
                                            en_tete = :entete,
                                            corps = :corps,
                                            date_modif = :date_modif
                                        WHERE annonce_id = :id');
            $now  = new DateTime();
            $now->setTimezone(new DateTimeZone(self::TIMEZONE));
            $stmt->bindValue(
                ':rubrique_id', $entity->getRubrique()
                                       ->getRubriqueId());
            $stmt->bindValue(':entete', $entity->getEntete());
            $stmt->bindValue(':corps', $entity->getCorps());
            $stmt->bindValue(':id', $entity->getAnnonceId());
            $stmt->bindValue(':date_modif', $now->format('Y-m-d H:i:s'), PDO::PARAM_STR);
//            foreach ($entity->getImgs() as $img) {
//                $stmt->bindParam(':image_src', $img);
//            }
            $stmt->execute();
            $count = $stmt->rowCount();
            $this->getCnx()
                 ->commit();
            return $count;
        } catch (Exception $e) {
            $this->getCnx()
                 ->rollBack();
            throw new DAOException($e->getMessage());
        }

    }

    /**
     * @param Annonce $annonce
     * @return int
     * @throws DAOException
     */
    public function updateVisite(Annonce $annonce)
    {
        try {
            $this->getCnx()
                 ->beginTransaction();
            $stmt = $this->getCnx()
                         ->prepare(
                             'UPDATE annonce
                                        SET visites = visites + 1
                                        WHERE annonce_id = :id');
            $stmt->bindValue(':id', $annonce->getAnnonceId());//            foreach ($entity->getImgs() as $img) {
            $stmt->execute();
            $count = $stmt->rowCount();
            $this->getCnx()
                 ->commit();
            return $count;
        } catch (Exception $e) {
            $this->getCnx()
                 ->rollBack();
            throw new DAOException($e->getMessage());
        }
    }

    /**
     * @param $id
     * @param $idRubrique
     * @return int rowcount
     * @throws DAOException
     */
    public function updateRubrique($id, $idRubrique)
    {
        try {
            $this->getCnx()
                 ->beginTransaction();
            $stmt = $this->getCnx()
                         ->prepare(
                             'UPDATE annonce 
                            SET rubrique_id = :rubId
                            WHERE annonce_id = :id');
            $stmt->bindParam(':rubId', $idRubrique);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $count = $stmt->rowCount();
            $this->getCnx()
                 ->commit();
            return $count;
        } catch (Exception $e) {
            $this->getCnx()
                 ->rollBack();
            throw new DAOException($e->getMessage());
        }
    }

    /**
     * @param Utilisateur $utilisateur
     * @return Annonce[]
     * @throws DAOException
     */
    public function getByUser(Utilisateur $utilisateur)
    {
        try {
            $this->getCnx()
                 ->beginTransaction();
//            $stmt = $this->getCnx()->prepare('SELECT * FROM annonce WHERE annonce_id = :id');
            $stmt = $this->getCnx()
                         ->prepare(
                             'SELECT a.annonce_id as a_id, a.en_tete, a.corps, a.date_creation as crea, 
                                                        a.date_modif as modif, a.date_limite as dlimit, a.visites as visit,
                                                        group_concat(image_src) AS images,
                                                        u.user_id, nom, mot_de_passe as mdp, mail, est_admin,  confirmation_token, created_at,
                                                        r.rubrique_id as r_id, libelle
                                                FROM annonce AS a
                                                LEFT JOIN image i ON a.annonce_id = i.annonce_id
                                                INNER JOIN utilisateur u ON a.user_id = u.user_id
                                                INNER JOIN rubrique r ON a.rubrique_id = r.rubrique_id
                                                WHERE a.user_id = :userId
                                                GROUP BY a.annonce_id');
            $stmt->bindValue(':userId', $utilisateur->getUserId());
            $stmt->execute();
            $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->getCnx()
                 ->commit();
            $annonces = array();
            foreach ($datas as $data) {
                $annonce    = $this->annonceFromArray($data);
                $annonces[] = $annonce;
            }
            return $annonces;
        } catch (Exception $e) {
            $this->getCnx()
                 ->rollBack();
            throw new DAOException($e->getMessage());
        }

    }

    /**
     * @param Rubrique $rub
     * @return Annonce[]
     * @throws DAOException
     */
    public function getByRub(Rubrique $rub)
    {
        try {
            $this->getCnx()
                 ->beginTransaction();
            $stmt = $this->getCnx()
                         ->prepare(
                             'SELECT a.annonce_id as a_id, a.en_tete, a.corps, a.date_creation as crea, 
                                                        a.date_modif as modif, a.date_limite as dlimit, a.visites as visit,
                                                        group_concat(image_src) AS images,
                                                        u.user_id, nom, mot_de_passe as mdp, mail, confirmation_token, created_at, est_admin,
                                                        r.rubrique_id as r_id, libelle
                                                FROM annonce AS a
                                                LEFT JOIN image i ON a.annonce_id = i.annonce_id
                                                INNER JOIN utilisateur u ON a.user_id = u.user_id
                                                INNER JOIN rubrique r ON a.rubrique_id = r.rubrique_id
                                                WHERE a.rubrique_id = :rubId
                                                GROUP BY a.annonce_id');

            $stmt->bindValue(':rubId', $rub->getRubriqueId());
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datas = $stmt->fetchAll();
            $this->getCnx()
                 ->commit();
            $annonces = array();
            foreach ($datas as $data) {
                $annonce    = $this->annonceFromArray($data);
                $annonces[] = $annonce;
            }
            return $annonces;
        } catch (Exception $e) {
            $this->getCnx()
                 ->rollBack();
            throw new DAOException($e->getMessage());
        }

    }

    /**
     * @return int rowcount
     * @throws Exception
     */
    public function deletePerimees()
    {

        try {
            $this->getCnx()
                 ->beginTransaction();
            $stmt = $this->getCnx()
                         ->prepare(
                             'DELETE FROM annonce 
                            WHERE DATE_ADD(date_creation, INTERVAL ' . self::VALIDITE_MAX . ') <= :now');
            $now  = new DateTime();
            $now->setTimezone(new DateTimeZone(self::TIMEZONE));
            $stmt->bindValue(':now', $now->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            $this->getCnx()
                 ->commit();
            return $count;
        } catch (Exception $e) {
            $this->getCnx()
                 ->rollBack();
            throw new DAOException($e->getMessage());
        }
    }

    /**
     * @return array
     * @throws DAOException
     */
    public function getAll()
    {
        try {
            $this->getCnx()
                 ->beginTransaction();
            $stmt = $this->getCnx()
                         ->query('SELECT * FROM annonce');
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Annonce');
            $data = $stmt->fetchAll();
            return $data;
        } catch (Exception $e) {
            $this->getCnx()
                 ->rollBack();
            throw new DAOException($e->getMessage());
        }
    }
//    /**
//     * @param array $annonces
//     * @return Annonce[]
//     * @throws Exception
//     */
//    public function hydrateAnnonce(array $annonces)
//    {
//        $annoncesTab = array();
//        foreach ($annonces as $datum) {
//            $annonce = new Annonce();
//            foreach ($datum as $key => $value) {
//                $key    = ucwords($key, "_");
//                $key    = preg_replace("/_/", "", $key);
//                $method = "set" . $key;
//                if (method_exists($annonce, $method)) {
//                    $annonce->$method($value);
//                }
//            }
//            $annoncesTab[] = $annonce;
//        }
//        return $annoncesTab;
//    }

}