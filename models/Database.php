<?php

require_once __DIR__ . '/../config/config.php';

class Database{

    private $connection;

    public function __construct(){

        try{

            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";chartset=utf8mb4";

            $this->connection = new PDO($dsn, DB_USER, DB_PASS);

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



        }
        catch(PDOException $e){

            die("Fallo en la conexión a la base de datos: " . $e->getMessage());

        }

    }

    public function getConnection(){
        return $this->connection;
    }

}