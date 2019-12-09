<?php


namespace Main\DAO;


use Exception;
use Main\Domain\Annonce;
use Main\Domain\Entity;
use Main\Domain\Image;
use PDO;

class MySQLImageDAO extends DAO
{
    /**
     * @param Image $image
     * @return mixed
     * @throws DAOException
     */
    public function insert(Image $image)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare('INSERT INTO image (annonce_id, image_src) VALUES (:annonce_id, :image_src)');
            $stmt->bindValue(':annonce_id', $image->getAnnonceId());
            $stmt->bindValue(':image_src', $image->getImageSrc());
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
     * @param int $id
     * @return mixed
     * @throws DAOException
     */
    public function getById(int $id)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare('SELECT * FROM image WHERE image_id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetchAll();
            $this->getCnx()->commit();
            return $this->hydrateImage($data)[0];
        }
        catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param Entity $img
     * @return int
     * @throws DAOException
     */
    public function delete(Entity $img)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare('DELETE FROM image  WHERE (image_id = :id)');
            $stmt->bindValue(':id', $img->getImageId());
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
     * @param Entity $img
     * @return int rowcount
     * @throws DAOException
     */
    public function update(Entity $img)//$id, $libelle
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare(
                'UPDATE image SET image_src = :image_src, annonce_id = :annonce_id
                                                        WHERE image_id = :id');
            $stmt->bindValue(':image_src', $img->getImageSrc());
            $stmt->bindValue(':annonce_id', $img->getAnnonceId());
            $stmt->bindValue(':id', $img->getImageId());
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
     * @param Annonce $annonce
     * @return array
     * @throws DAOException
     */
    public function getByAnnonce(Annonce $annonce)
    {
        try {
            $this->getCnx()->beginTransaction();
            $stmt = $this->getCnx()->prepare('SELECT * FROM image WHERE annonce_id = :id');
            $stmt->bindValue(':id', $annonce->getAnnonceId());
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetchAll();
            $this->getCnx()->commit();
            return $this->hydrateImage($data);
        }
        catch (Exception $e) {
            $this->getCnx()->rollBack();
            throw new DAOException($e->getMessage(), $e->getCode());
        }
    }

    public function hydrateImage(array $images)
    {
        $imagesTab = array();
        foreach ($images as $datum) {
            $image = new Image();
            foreach ($datum as $key => $value) {
                $key    = ucwords($key, "_");
                $key    = preg_replace("/_/", "", $key);
                $method = "set" . $key;
                if (method_exists($image, $method)) {
                    $image->$method($value);
                }
            }
            $imagesTab[] = $image;
        }
        return $imagesTab;
    }
}