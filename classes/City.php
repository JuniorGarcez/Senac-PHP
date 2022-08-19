<?php
    
    class City
    {
        private static $conn;
        
        public static function getConnection()
        {
            if (empty(self::$conn)) {
                $connection = parse_ini_file('config/books.ini');
                $host = $connection['host'];
                $port = $connection['port'];
                $name = $connection['name'];
                $user = $connection['user'];
                $pass = $connection['pass'];
                
                self::$conn = new PDO(
                    "mysql:host={$host};port={$port};dbname={$name}",
                    "{$user}",
                    "{$pass}",
                    [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8']
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$conn;
        }
        
        public static function all($id = null)
        {
            $conn = self::getConnection();
            $result = $conn->query("SELECT * FROM cities");
            return $result;
        }
    }
