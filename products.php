<?php

include 'database.php';

class Product
{
    private static $tableName = 'category';

    private static function getConnection()
    {
        $database = new Database();
        return $database->getConnection();
    }

    public static function all()
    {
        $connection = self::getConnection();
        $query = "SELECT * FROM " . self::$tableName;
        $statement = $connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($id)
    {
        $connection = self::getConnection();
        $query = "DELETE FROM " . self::$tableName . " WHERE id = :id";
        $statement = $connection->prepare($query);
        $statement->bindParam(':id', $id);
        return $statement->execute();
    }

    public static function show($id)
    {
        $connection = self::getConnection();
        $query = "SELECT * FROM " . self::$tableName . " WHERE id = :id";
        $statement = $connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($name, $img)
    {
        $connection = self::getConnection();
        $query = "INSERT INTO " . self::$tableName . " (name, img) VALUES (:name, :img)";
        $statement = $connection->prepare($query);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':img', $img);
        return $statement->execute();
    }

    public static function update($id, $name, $img)
    {
        $connection = self::getConnection();
        $query = "UPDATE " . self::$tableName . " SET name = :name, img = :img WHERE id = :id";
        $statement = $connection->prepare($query);  
        $statement->bindParam(':id', $id);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':img', $img);
        return $statement->execute();
    }

    public static function search($keyword)
    {
        $connection = self::getConnection();
        $query = "SELECT * FROM " . self::$tableName . " WHERE name LIKE :keyword";
        $statement = $connection->prepare($query);
        $keyword = "%$keyword%";
        $statement->bindParam(':keyword', $keyword);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function count()
    {
        $connection = self::getConnection();
        $query = "SELECT COUNT(*) as count FROM " . self::$tableName;
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}


