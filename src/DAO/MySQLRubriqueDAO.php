<?php


namespace Main\DAO;


use Exception;
use Main\Domain\Entity;
use Main\Domain\Rubrique;
use PDO;

class MySQLRubriqueDAO extends DAO
{
    /**
     * @param Entity $rubrique
     * @return string last insert id
     * @throws DAOException
     */
    public function insert(Entity $rubrique)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare('INSERT INTO rubrique (libelle) VALUES (:libelle)');
            $stmt->bindValue(':libelle', $rubrique->getLibelle());
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
     * @param Entity $rub
     * @return int rowcount
     * @throws DAOException
     */
    public function delete(Entity $rub)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare('DELETE FROM rubrique  WHERE (rubrique_id = :id)');
            $stmt->bindValue(':id', $rub->getRubriqueId());
            $stmt->execute();
            $count = $stmt->rowCount();
            $this->getCnx()->commit();
            return $count;
        }
        catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param Entity $rub
     * @return int rowcount
     * @throws DAOException
     */
    public function update(Entity $rub)//$id, $libelle
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare(
                'UPDATE rubrique SET libelle = :libelle
                                                        WHERE rubrique_id = :id');
            $stmt->bindValue(':libelle', $rub->getLibelle());
            $stmt->bindValue(':id', $rub->getRubriqueId());
            $stmt->execute();
            $count = $stmt->rowCount();
            $this->getCnx()->commit();
            return $count;
        }
        catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Get all rubriques
     *
     * @return Rubrique[]
     * @throws DAOException
     */
    public function getAll()
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->query('SELECT * FROM rubrique ORDER BY libelle');
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Rubrique');
            $data = $stmt->fetchAll();
            $this->getCnx()->commit();
            return $data;
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
            $stmt = $this->getCnx()->prepare('SELECT * FROM rubrique WHERE libelle = :libelle');
            $stmt->bindParam(':libelle', $name);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Rubrique');
            $data = $stmt->fetch();
            $this->getCnx()->commit();
            return $data;
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
            $stmt = $this->getCnx()->prepare('SELECT * FROM rubrique WHERE rubrique_id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Main\Domain\Rubrique');
            $data = $stmt->fetch();
            $this->getCnx()->commit();
            return $data;
        }
        catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }


}