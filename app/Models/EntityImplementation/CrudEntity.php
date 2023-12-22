<?php
namespace App\Models\EntityImplementation;
require __DIR__ . '/../../../vendor/autoload.php';

use Exception;
use PDOException;
use PDO;
use \App\Database\DatabaseConnection;

trait CrudEntity
{
    use BaseEntity;
    protected $pdo;

    public function __construct(){
        $this->pdo = DatabaseConnection::getInstance()->getConnection();
    }

    // Set up a PDO connection (you may need to adjust these parameters)
    protected static function getConnection()
    {
        try {
            return DatabaseConnection::getInstance()->getConnection();
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function getTableName(): string
    {
        return '';
    }

    public function create(array $data)
{
    try {
        $pdo = self::getConnection();

        // Build the query based on the data keys and values
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $stmt = $pdo->prepare("INSERT INTO {$this->getTableName()} ($columns) VALUES ($values)");
        $stmt->execute(array_values($data));

        return $pdo->lastInsertId();

    } catch (PDOException $e) {
        throw new Exception("Error saving entity: " . $e->getMessage());
    }
}


public function read($id, array $columns = ['*'])
{
    try {
        $pdo = self::getConnection();

        // Convert columns array to a comma-separated string
        $columnsString = implode(', ', $columns);

        $stmt = $pdo->prepare("SELECT $columnsString FROM {$this->getTableName()} WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result;
        } else {
            throw new Exception("Entity not found.");
        }

    } catch (PDOException $e) {
        throw new Exception("Error reading entity: " . $e->getMessage());
    }
}

public function readAll()
    {
        try {
            $pdo = self::getConnection();

            $stmt = $pdo->prepare("SELECT * FROM {$this->getTableName()}");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            throw new Exception("Error reading all entities: " . $e->getMessage());
        }
    }


    public function update(array $data, $id)
{
    try {
        $pdo = self::getConnection();

        $setClause = implode(', ', array_map(function ($key) {
            return "$key = ?";
        }, array_keys($data)));

        $stmt = $pdo->prepare("UPDATE {$this->getTableName()} SET $setClause WHERE id = ?");
        
        $values = array_values($data);
        $values[] = $id;

        $stmt->execute($values);

        echo "Entity updated.\n";
    } catch (PDOException $e) {
        throw new Exception("Error updating entity: " . $e->getMessage());
    }
}

    


    public function delete($field, $value)
    {
        try {
            $pdo = self::getConnection();

            $stmt = $pdo->prepare("DELETE FROM {$this->getTableName()} WHERE {$field} = ?");
            $stmt->execute([$value]);

            echo "Entity deleted.\n";
        } catch (PDOException $e) {
            throw new Exception("Error deleting entity: " . $e->getMessage());
        }
    }

    public function getEntityByField(string $field, $value) {
        try {
            $pdo = self::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE $field = ?");
            $stmt->execute([$value]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            throw new Exception("Error fetching entity: " . $e->getMessage());
        }
    }

    // Authentication.php

public function getUserRole($userId) {
    try {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("SELECT r.name FROM roleuser ru
                              JOIN `role` r ON ru.roleId = r.id
                              WHERE ru.userId = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['name'] : null;
    } catch (PDOException $e) {
        throw new Exception("Error fetching user role: " . $e->getMessage());
    }
}

public function getTheMostReservation()
    {
        try {
            $sql = "SELECT b.title, COUNT(r.id) AS reservation_count 
                    FROM book b 
                    LEFT JOIN reservation r ON b.id = r.id_book 
                    GROUP BY b.title 
                    ORDER BY reservation_count DESC";

            $stmt = $this->database->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log or handle the exception appropriately
            throw $e;
        }


    }
}


