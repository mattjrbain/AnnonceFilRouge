<?php


namespace Main\DAO;


use PDO;
use PDOException;

class MySQLConnexion
{
    private static $cnx;
    private static $instance = null;

    private function __construct()
    {
        $host = '127.0.0.1';
        $db   = 'annonces';
        $user = 'root';
        $pass = '';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            self::$cnx = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
//            echo ("erreur connexion");
        }
    }

    public static function getConnexion(){
        if(!self::$instance){
            self::$instance = new MySQLConnexion();
        }
        return self::$cnx;
    }
}