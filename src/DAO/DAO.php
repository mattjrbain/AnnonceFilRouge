<?php


namespace Main\DAO;


use Exception;
use PDO;
use PDOException;

abstract class DAO
{
    CONST TIMEZONE = 'Europe/Paris';

    /**
     * @var PDO
     */
    protected $cnx;

    /**
     * DAO constructor.
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->cnx = MySQLConnexion::getConnexion();
        }
        catch (PDOException $e) {
//            echo($e->getMessage()."\n");
//            echo ((int)$e->getCode()."\n");
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return PDO
     */
    public function getCnx()
    {
        return $this->cnx;
    }

    /**
     * @param $className
     * @return DAO
     */
    public static function get($className)
    {
        $class =  __NAMESPACE__ . '\\MySQL' . $className . 'DAO';
        return new $class;
    }



}