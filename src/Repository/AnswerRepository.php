<?php

namespace App\Repository;

use PDO;

class AnswerRepository implements RepositoryInterface
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByQuestionId(int $questionId): array
    {
        $sql= 'SELECT * FROM answer WHERE id_question = :questionId';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':questionId' => $questionId]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result ?: [];

    }
    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    public function find(int $id): object
    {
        // TODO: Implement find() method.
    }

    public function save(object $entity): void
    {
        // TODO: Implement save() method.
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