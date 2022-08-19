<?php
    
    class Person
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
        
        public static function save($person)
        {
            $conn = self::getConnection();
            if (empty($person['id'])) {
                $result = $conn->query("SELECT max(id) as next FROM person");
                $row = $result->fetch();
                $person['id'] = (int)$row['next'] + 1;
                $sql = "INSERT INTO person (id, name, address, district, phone, mail, id_city) VALUES (:id, :name, :address, :district, :phone, :mail, :id_city)";
            } else {
                $sql = "UPDATE person SET name = :name, address = :address, district = :district, phone = :phone, mail = :mail, id_city = :id_city WHERE id = :id ";
            }
            $result = $conn->prepare($sql);
            $result->execute(
                [
                    ':id' => $person['id'],
                    ':name' => $person['name'],
                    ':address' => $person['address'],
                    ':district' => $person['district'],
                    ':phone' => $person['phone'],
                    ':mail' => $person['mail'],
                    ':id_city' => $person['id_city']
                ]
            );
        }
        
        public static function find($id)
        {
            $conn = self::getConnection();
            $result = $conn->query("SELECT * FROM person WHERE id='{$id}'");
            
            return $result->fetch();
        }
        
        public static function delete($id)
        {
            $conn = self::getConnection();
            $result = $conn->query("DELETE FROM person WHERE id='{$id}'");
            
            return $result;
        }
        
        public static function all()
        {
            $conn = self::getConnection();
            $result = $conn->query("SELECT * FROM person");
            
            return $result;
        }
        
    }
