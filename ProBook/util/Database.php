<?php
    class Database {
        protected $conn;

        static function createDBConnection($host, $user, $password, $dbName){
            $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";

            try {
                $pdo = new PDO($dsn, $user, $password);
                return $pdo;
            } catch (\PDOException $e){
                // phpinfo();
                http_response_code(500);
                echo $e;
                exit();  
            }
        }

        function __construct(PDO $conn){
            $this->conn = $conn;
        }
    }

?>