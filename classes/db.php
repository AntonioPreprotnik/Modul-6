<?php

//Za uključivanje prikaza grešaka na web stranici
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'DotEnv.php';

class Database {

    private $connection;
    private $dbhost;
    private $database;
    private $user;
    private $pass;

    public function __construct() {

        if(file_exists(__DIR__ . '/../.env')) {
            $dotenv = new DotEnv(__DIR__ . '/../.env');
            $dotenv->load();
        }
        
        $this->dbhost = getenv('DB_HOST');
        $this->database = getenv('DB_NAME');
        $this->user = getenv('DB_USER');
        $this->pass = getenv('DB_PASS');


        try {

            //kreiraj konekciju
            $result = new PDO("mysql:host=$this->dbhost;dbname=$this->database", $this->user, $this->pass);

            // set the PDO error mode to exception
            $result->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->connection = $result;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function get_all() {

        $data = [];
        
        try {
            $statement = $this->connection->prepare("SELECT * FROM test1");

            $statement->execute();

            if($statement->rowCount()) {
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            } 

            return $data;

        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insert($params) {

        try {

            $data = $params['tekst'];

            $statement = $this->connection->prepare("INSERT INTO test1 (tekst) VALUES (:tekst)");

            $statement->bindParam(':tekst', $data);

            $statement->execute();

            header('Location: index.php');
            exit();

        } catch(PDOException $e) {
            return $e->getMessage();
        }
 
    }

    public function edit($id) {

        $data  = [];

        $statement = $this->connection->prepare("SELECT * FROM test1 WHERE id = :id");

        $statement->bindParam(':id', $id);
        
        $statement->execute();

        if($statement->rowCount()) {
            $data = $statement->fetch(PDO::FETCH_ASSOC);
        }

        return $data;
    }

    public function update($params) {

        try {

            $statement = $this->connection->prepare("UPDATE test1 SET tekst = :tekst WHERE id = :id");

            $statement->bindParam(':id', $params['id']);
            $statement->bindParam(':tekst', $params['tekst']);

            $statement->execute();

            header('Location: index.php');
            exit();

        } catch(PDOException $e) {
            return $e->getMessage();
        }
 
    }

    public function delete($id) {
        
        $statement = $this->connection->prepare("DELETE FROM test1 WHERE id = :id");

        $statement->bindParam(':id', $id);
    
        $statement->execute();
    
        header('Location: index.php');
        exit();
    }
}

?>