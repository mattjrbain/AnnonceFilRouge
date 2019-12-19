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
            $now = new DateTime();
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
        }
        catch (Exception $e) {
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
            $stmt->bindValue(':id', $utilisateur->getUserId());
            $stmt->execute();
            $count = $stmt->rowCount();
            $this->getCnx()->commit();
            return $count;
        }
        catch (DAOException $e) {
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
                'SELECT * FROM utilisateur
                                                        WHERE nom = :nom');
            $stmt->bindValue(':nom', $user->getNom());
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Utilisateur');
            if ($data = $stmt->fetch()) {
                if (password_verify($user->getMotDePasse(), $data->getMotDePasse())) {
                    $confirm = $data->getConfirmedAt();
                    if ($data->getConfirmedAt() != null || $data->getConfirmedAt() != false) {
                        $this->getCnx()->commit();
                        $_SESSION['user']    = $data->getNom();
                        $_SESSION['isAdmin'] = $data->isEstAdmin();
                        unset($_SESSION['errorPass']);
                        return $data;//->getUserId();
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
        }
        catch (Exception $e) {
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
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Utilisateur');
            $user = $stmt->fetch();
            $this->getCnx()->commit();
            return $user;
        }
        catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
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
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Utilisateur');
            $user = $stmt->fetch();
            $this->getCnx()->commit();
            return $user;
        }
        catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    public function getAll()
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->query('SELECT * FROM utilisateur');
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Utilisateur');
            $data = $stmt->fetchAll();
            $this->getCnx()->commit();
            return $data;
        }
        catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }
}