<?php

namespace App\Repository;

use App\Database\Connection;
use App\Model\User;
use PDO;

class UserRepository implements RepositoryInterface
{

    private static PDO $connection;

    public function __construct(PDO $connection)
    {
        self::$connection = $connection;
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    public function find(int $id): object
    {
        // TODO: Implement find() method.
    }

    public function findByEmail(string $email): object
    {
        $sql = "SELECT * FROM registered_user WHERE email = :email";
        $stmt = self::$connection->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function save(object $entity): void
    {
        $sql = "INSERT INTO registered_user (email, password_hash) VALUES (?,?)";
        $stmt = self::$connection->prepare($sql);
        $stmt->execute([$entity->getEmail(), $entity->getPassword()]);
    }

    public function update(object $entity): void
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }
}