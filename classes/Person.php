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
            $sql = "INSERT INTO person (id, first_name, last_name, zipcode, 
            address, number, complement, district, city, state, phone, mail)
            VALUES (:id, :first_name, :last_name, :zipcode, :address, :number, 
            :complement, :district, :city, :state, :phone, :mail)";
        } else {
            $sql = "UPDATE person SET 
            id = :id, first_name = :first_name, last_name = :last_name, zipcode = :zipcode, address = :address, number = :number, 
            complement = :complement, district = :district, city = :city, state = :state, phone = :phone, mail = :mail";
        }
        $result = $conn->prepare($sql);
        $result->execute(
            [
                ':id' => $person['id'],
                ':first_name' => $person['first_name'],
                ':last_name' => $person['last_name'],
                ':zipcode' => $person['zipcode'],
                ':address' => $person['address'],
                ':number' => $person['number'],
                ':complement' => $person['complement'],
                ':district' => $person['district'],
                ':city' => $person['city'],
                ':state' => $person['state'],
                ':phone' => $person['phone'],
                ':mail' => $person['mail']
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
