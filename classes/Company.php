<?php

class Company
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

    public static function save($company)
    {
        $conn = self::getConnection();
        if (empty($company['id'])) {
            $result = $conn->query("SELECT max(id) as next FROM companies");
            $row = $result->fetch();
            $company['id'] = (int)$row['next'] + 1;
            $sql = "INSERT INTO companies (id, company_name, company_fantasy, company_phone, 
            company_street, company_number, company_complement, company_district, company_zipcode, company_city, 
            company_state, company_country, company_cnpj)

            VALUES (:id, :company_name, :company_fantasy, :company_phone, :company_street, :company_number, 
            :company_complement, :company_district, :company_zipcode, :company_city, :company_state, :company_country, :company_cnpj)";
        } else {
            $sql = "UPDATE companies SET 
            id = :id,company_name = :company_name,company_fantasy = :company_fantasy,company_phone = :company_phone,
            company_street = :company_street,company_number = :company_number,company_complement = :company_complement,
            company_district = :company_district,company_zipcode = :company_zipcode,company_city = :company_city,company_state = :company_state,
            company_country = :company_country, company_cnpj = :company_cnpj";
        }
        $result = $conn->prepare($sql);
        $result->execute(
            [
                ':id' => $company['id'],
                ':company_name' => $company['company_name'],
                ':company_fantasy' => $company['company_fantasy'],
                ':company_phone' => $company['company_phone'],
                ':company_street' => $company['company_street'],
                ':company_number' => $company['company_number'],
                ':company_complement' => $company['company_complement'],
                ':company_district' => $company['company_district'],
                ':company_zipcode' => $company['company_zipcode'],
                ':company_city' => $company['company_city'],
                ':company_state' => $company['company_state'],
                ':company_country' => $company['company_country'],
                ':company_cnpj' => $company['company_cnpj']

            ]
        );
    }

    public static function find($id)
    {
        $conn = self::getConnection();
        $result = $conn->query("SELECT * FROM companies WHERE id='{$id}'");

        return $result->fetch();
    }

    public static function delete($id)
    {
        $conn = self::getConnection();
        $result = $conn->query("DELETE FROM companies WHERE id='{$id}'");

        return $result;
    }

    public static function all()
    {
        $conn = self::getConnection();
        $result = $conn->query("SELECT * FROM companies");

        return $result;
    }
}
