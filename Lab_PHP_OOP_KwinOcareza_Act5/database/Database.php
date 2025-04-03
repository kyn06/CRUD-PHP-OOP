<?php

class Database{
    
    private $host = "localhost";
    private $username= "root";
    private $password = "Jove_062224!";
    private $database = "library";
    private $conn;

    public function __construct(){
        $this->conn = mysqli_connect(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if(!$this->conn){
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function setConnection($conn){
        $this->conn = $conn;
    }

    public function getConnection(){
        return $this->conn;
    }

    public function __destruct(){
        mysqli_close($this->conn);
    }
}