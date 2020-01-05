<?php


namespace Main\controllers;


use Exception;
use Main\DAO\MySQLAnnonceDAO;
use Main\DAO\MySQLImageDAO;
use Main\DAO\MySQLRubriqueDAO;
use Main\DAO\MySQLUtilisateurDAO;

class MyDIContainer implements Container
{
    /**
     * @return MySQLAnnonceDAO
     * @throws Exception
     */
    public function getAnnonceDAO()
    {
        return new MySQLAnnonceDAO();
    }

    /**
     * @return MySQLRubriqueDAO
     * @throws Exception
     */
    public function getRubriqueDAO()
    {
        return new MySQLRubriqueDAO();
    }

    /**
     * @return MySQLImageDAO
     * @throws Exception
     */
    public function getImageDAO()
    {
        return new MySQLImageDAO();
    }

    /**
     * @return MySQLUtilisateurDAO
     * @throws Exception
     */
    public function getUtilisateurDAO()
    {
        return new MySQLUtilisateurDAO();
    }
}