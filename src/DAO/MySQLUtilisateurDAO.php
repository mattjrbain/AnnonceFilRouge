<?php


namespace Main\DAO;


use Exception;
use Main\Domain\Utilisateur;
use PDO;

class MySQLUtilisateurDAO extends DAO
{
    /**
     * @param Utilisateur $utilisateur
     * @return string last insert id
     * @throws DAOException
     */
    public function insert(Utilisateur $utilisateur)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare(
                'INSERT INTO utilisateur(nom, mot_de_passe, mail) 
                                                        VALUES (:nom, :mdp, :mail)');
            $mdp  = password_hash($utilisateur->getMotDePasse(), PASSWORD_BCRYPT);
            $stmt->bindValue(':nom', $utilisateur->getNom());
            $stmt->bindParam(':mdp', $mdp);
            $stmt->bindParam(':mail', $utilisateur->getMail());
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
                    $this->getCnx()->commit();
                    return $data;//->getUserId();
                } else {
                    throw new DAOException("Mauvais mot de passe");
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
    {
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
     * @return mixed
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
}