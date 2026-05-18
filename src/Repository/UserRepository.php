<?php

namespace App\Repository;

use App\Database\Connection;
use App\Model\User;
use PDO;

class UserRepository
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

    public function find(int $id): ?User
    {
        $sql = "SELECT * FROM registered_user WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new User($data['email'], $data['password_hash'], $data['id']);
    }

    public function findByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM registered_user WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new User($data['email'], $data['password_hash'], $data['id']);
    }


    public function save(User $user): int
    {
        $sql = "INSERT INTO registered_user (email, password_hash) VALUES (?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$user->getEmail(), $user->getPassword()]);

        return $this->connection->lastInsertId();
    }

    public function update(User $user): void
    {
        // TODO: Implement update() method.
        $sql = "UPDATE registered_user SET email = :email, password_hash = :password_hash WHERE id = :id";

        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            'email' => $user->getEmail(),
            'password_hash' => $user->getPassword(),
            'id' => $user->getId()
        ]);
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
        $sql = "DELETE FROM registered_user WHERE id = :id";

        $stmt = $this->connection->prepare($sql);

        $stmt->execute(['id' => $id]);
    }
}
