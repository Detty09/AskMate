<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection {
    private static ?PDO $connection = null;

    public static function getConnection(): PDO {
        if (self::$connection === null) {
            $configFile = __DIR__ . "/../../config.json";
            if (!file_exists($configFile)) {
                die("Missing database configuration file");
            }
            $config = json_decode(file_get_contents($configFile), true);
            $db = $config['db'];

            try {
                self::$connection = new PDO(
                    "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8mb4",
                    $db['user'],
                    $db['password']
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }

        }
        return self::$connection;
    }

}
