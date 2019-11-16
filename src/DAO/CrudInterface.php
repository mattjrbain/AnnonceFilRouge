<?php


namespace Main\DAO;


use Main\Domain\Entity;

interface CrudInterface
{
    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param Entity $entity
     * @return mixed
     */
    public function insert(Entity $entity);

    /**
     * @param Entity $entity
     * @return mixed
     */
    public function delete(Entity $entity);
}