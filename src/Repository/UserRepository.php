<?php

namespace App\Repository;

use App\Database\Connection;
use App\Model\User;
use PDO;

class UserRepository implements RepositoryInterface
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findAll(): array
    {
        $sql = "SELECT u.id, u.email, u.registration_time,
                    COUNT(DISTINCT q.id) AS questions,
                    COUNT(DISTINCT a.id) AS answers
                FROM registered_user u
                LEFT JOIN question q ON u.id = q.id_registered_user
                LEFT JOIN answer a ON u.id = a.id_registered_user
                GROUP BY u.id, u.email, u.registration_time";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): object
    {
        // TODO: Implement find() method.
    }

    public function findByEmail(string $email): object
    {
        $sql = "SELECT * FROM registered_user WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function save(object $entity): int
    {
        $sql = "INSERT INTO registered_user (email, password_hash) VALUES (?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$entity->getEmail(), $entity->getPassword()]);

        return $this->connection->lastInsertId();
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