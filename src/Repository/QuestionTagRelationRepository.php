<?php

namespace App\Repository;

class QuestionTagRelationRepository implements RepositoryInterface
{
    private \PDO $connection;

    public function __construct(\PDO $connection) {
        $this->connection = $connection;
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    public function find(int $id): ?object
    {
        // TODO: Implement find() method.
    }

    public function save(object $entity): int
    {
        $sql = "INSERT INTO rel_question_tag (id_question, id_tag) VALUES(?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$entity->getQuestionId(), $entity->getTagId()]);

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