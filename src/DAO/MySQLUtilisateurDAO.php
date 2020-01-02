<?php


namespace Main\DAO;


use DateTime;
use Exception;
use Main\Domain\Utilisateur;
use PDO;

class MySQLUtilisateurDAO extends DAO
{
    /**
     * @param Utilisateur $utilisateur
     * @return Utilisateur
     * @throws DAOException
     */
    public function insert(Utilisateur $utilisateur)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare(
                'INSERT INTO utilisateur(nom, mot_de_passe, mail, created_at, confirmation_token) 
                                                        VALUES (:nom, :mdp, :mail, :created_at, :confirmation_token)');
            $now  = new DateTime();
            $mdp  = password_hash($utilisateur->getMotDePasse(), PASSWORD_BCRYPT);
            $stmt->bindValue(':nom', $utilisateur->getNom());
            $stmt->bindParam(':mdp', $mdp);
            $stmt->bindValue(':mail', $utilisateur->getMail());
            $stmt->bindValue(':created_at', $now->format('Y-m-d H:i:s'));
            $stmt->bindValue(':confirmation_token', $utilisateur->getConfirmationToken());
            $stmt->execute();
            $lastId = $this->getCnx()->lastInsertId();
            $this->getCnx()->commit();
            return $this->getById($lastId);
        } catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param Utilisateur $utilisateur
     * @return int
     * @throws DAOException
     */
    public function update(Utilisateur $utilisateur)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare(
                'UPDATE utilisateur 
                            SET nom = :nom,
                                mail = :mail,
                                confirmed_at = :confirmed_at
                                                        WHERE user_id = :id');
            $stmt->bindValue(':nom', $utilisateur->getNom());
            $stmt->bindValue(':mail', $utilisateur->getMail());
            $stmt->bindValue(':confirmed_at', $utilisateur->getConfirmedAt()->format('Y-m-d H:i:s'));
            $stmt->bindValue(':id', $utilisateur->getUserId(), PDO::PARAM_INT);
//            $stmt->bindValue(':mot_de_passe', password_hash($utilisateur->getMotDePasse(), PASSWORD_BCRYPT));
//            $stmt->bindValue(':mot_de_passe', $utilisateur->getMotDePasse());
            $stmt->execute();
            $count = $stmt->rowCount();
            $this->getCnx()->commit();
            return $count;
        } catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param Utilisateur $utilisateur
     * @return int
     * @throws DAOException
     */
    public function updatePWD(Utilisateur $utilisateur)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare(
                'UPDATE utilisateur 
                            SET mot_de_passe = :mot_de_passe
                                /*reset_at = NOW() */
                            WHERE user_id = :id');
            $stmt->bindValue(':id', $utilisateur->getUserId());
            $stmt->bindValue(':mot_de_passe', password_hash($utilisateur->getMotDePasse(), PASSWORD_BCRYPT));
            $stmt->execute();
            $count = $stmt->rowCount();
            $this->getCnx()->commit();
            return $count;
        } catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param Utilisateur $user
     * @return string identified user id
     * @throws DAOException
     */
    public function identifier(Utilisateur $user)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare(
                'SELECT * FROM utilisateur WHERE nom = :nom');
//            $nom = $user->getNom();
            $stmt->bindValue(':nom', $user->getNom(), PDO::PARAM_STR);
            $stmt->execute();
//            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Utilisateur');
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
//            if ($data = $this->userFromArray($stmt->fetch())) {
            if ($userArray = $stmt->fetch()) {
//                $truc = $stmt->fetch();
//                $userFromDB = $this->userFromArray($userArray);
                $userFromDB = $this->hydrate($userArray, 'Utilisateur');
                if (password_verify($user->getMotDePasse(), $userFromDB->getMotDePasse())) {
                    if ($userFromDB->getConfirmedAt() != null || $userFromDB->getConfirmedAt() != false) {
                        $this->getCnx()->commit();
                        $_SESSION['user']    = $userFromDB->getNom();
                        $_SESSION['isAdmin'] = $userFromDB->isEstAdmin();
                        unset($_SESSION['errorPass']);
                        return $userFromDB;//->getUserId();
                    } else {
                        throw new DAOException("Vous n'avez pas confirmé votre adresse mail. Votre compte n'est pas encore activé.");

                    }
                } else {
//                    $_SESSION['errorPass'] = "Mauvais mot de passe";
//                    header('Location: ?action=connection');
                    throw new DAOException("Nom d'utilisateur ou mot de passe erroné.");
                }
            } else {
                throw new DAOException($user->getNom() . " inexistant.");
            }
        } catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param string $name
     * @return mixed
     * @throws DAOException
     */
    public function getByName(string $name)
    {//todo: make userDAO again considering dates
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare('SELECT * FROM utilisateur WHERE nom = :nom');
            $stmt->bindParam(':nom', $name);
            $stmt->execute();
//            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Utilisateur');
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetch();
            $this->getCnx()->commit();
//            return $this->userFromArray($user);
            return $this->hydrate($user, 'Utilisateur');
        } catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    public function userFromArray(array $data)
    {
        $created_at   = DateTime::createFromFormat('Y-m-d H:i:s', $data['created_at']) ?? null;
        $confirmed_at = $data['confirmed_at'] ? DateTime::createFromFormat('Y-m-d H:i:s', $data['confirmed_at']) : null;
        return new Utilisateur($data['nom'], $data['mot_de_passe'], $data['mail'], $data['confirmation_token'],
                               $created_at, $data['est_admin'], $data['user_id'], $confirmed_at);
    }

    /**
     * @param int $id
     * @return Utilisateur
     * @throws DAOException
     */
    public function getById(int $id)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare('SELECT * FROM utilisateur WHERE user_id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
//            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Utilisateur');
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetch();
            $this->getCnx()->commit();
//            return $this->userFromArray($user);
            return $this->hydrate($user, 'Utilisateur');
        } catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    public function getAll()
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->query('SELECT * FROM utilisateur');
//            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Utilisateur');
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetchAll();
            $this->getCnx()->commit();
//            return $data;
            $users = array();
//            $users[] = $this->hydrate($data, "Utilisateur");
            foreach ($data as $datum) {
//                $users[] = $this->userFromArray($datum);
                $users[] = $this->hydrate($datum, 'Utilisateur');
            }
            return $users;

        } catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    public function updateReset($mail, $token)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare(
                'UPDATE utilisateur 
                            SET reset_token = :reset_token,
                                reset_at = NOW()
                                                        WHERE mail = :mail');
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':reset_token', $token);
            $stmt->execute();
            $count = $stmt->rowCount();
            $this->getCnx()->commit();
            return $count;
        } catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param string $mail
     * @return Utilisateur|null
     * @throws DAOException
     */
    public function getByMail(string $mail)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare('SELECT * FROM utilisateur WHERE mail = :mail');
            $stmt->bindParam(':mail', $mail);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($user = $stmt->fetch()) {
                $this->getCnx()->commit();
//                return $this->userFromArray($user);
                return $this->hydrate($user, 'Utilisateur');
            } else {
                throw new DAOException("Ce mail n'est pas dans notre bdd.");
            }
        } catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    public function hydrate(array $array, string $object)
    {
        $object = "Main\Domain\\" . $object;
        $target = new $object();
        foreach ($array as $key => $value) {
            $key    = ucwords($key, "_");
            $key    = preg_replace("/_/", "", $key);
            $method = "set" . $key;
            if (method_exists($target, $method)) {
                $target->$method($value);
            }
        }
        return $target;
    }
}