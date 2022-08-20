<?php

namespace App\Core;

//on importe PDO
use PDO;
use PDOException;

class DB extends PDO {

    //instance unisue de la classe
    private static $instance;

    //informations de connection
    private const DBHOST = 'localhost';
    private const DBUSER = 'root';
    private const DBPASS = '';
    private const DBNAME = 'demo_poo';

    private function __construct () {

        //DSN de connection

        $_dsn = 'mysql:dbname='. self::DBNAME . ';host=' . self::DBHOST;

        //on appelle le constructeur de la classe PDO
        try{
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e) {

            die ($e->getMessage());
            
        }
    }

    public static function getInstance():self {
        
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}