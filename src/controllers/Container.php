<?php

namespace Main\controllers;

use Exception;
use Main\DAO\MySQLAnnonceDAO;
use Main\DAO\MySQLImageDAO;
use Main\DAO\MySQLRubriqueDAO;
use Main\DAO\MySQLUtilisateurDAO;

interface Container
{
    /**
     * @return MySQLAnnonceDAO
     * @throws Exception
     */
    public function getAnnonceDAO();

    /**
     * @return MySQLRubriqueDAO
     * @throws Exception
     */
    public function getRubriqueDAO();

    /**
     * @return MySQLImageDAO
     * @throws Exception
     */
    public function getImageDAO();

    /**
     * @return MySQLUtilisateurDAO
     * @throws Exception
     */
    public function getUtilisateurDAO();
}