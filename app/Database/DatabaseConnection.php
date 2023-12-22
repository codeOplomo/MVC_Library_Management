<?php
namespace App\Database;
use \PDOException;
use \Exception;
use PDO;

require __DIR__ . '/../../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class DatabaseConnection
{
    private $connection;
    private static $instance = null;
    private function __construct() {
        $dsn = "mysql:host={$_ENV["DB_HOST"]};dbname={$_ENV["DB_DATABASE"]}";

        try {
            $this->connection = new PDO($dsn, $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            try {
                self::$instance = new self();
            } catch (Exception $e) {
                throw $e;
            }
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }

}
