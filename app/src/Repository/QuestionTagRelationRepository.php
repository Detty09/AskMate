<?php

namespace App\Repository;

use PDO;

class QuestionTagRelationRepository
{
    private PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    public function find(int $id): ?object
    {
    }

    public function findByQuestionId(int $id): array {
        $sql = 'SELECT id_question, id_tag, name FROM rel_question_tag
                INNER JOIN tag ON rel_question_tag.id_tag = tag.id
                WHERE id_question = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByQuestionIdAndTagId(int $questionId, int $tagId): array
    {
        $sql = "SELECT * FROM rel_question_tag
                WHERE id_question = :id_question AND id_tag = :id_tag";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(["id_question" => $questionId, "id_tag" => $tagId]);

        $relation = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($relation)) {
            return [];
        }
        return $relation;
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
        $stmt = $this->connection->prepare("DELETE FROM rel_question_tag WHERE id_question = :id_question");
        $stmt->execute([
            "id_question" => $id
        ]);
    }

    public function deleteByQuestionAndTagId(int $questionId, int $tagId): void
    {
        $sql = "DELETE FROM rel_question_tag WHERE id_question = :id_question AND id_tag = :id_tag";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id_question' => $questionId, 'id_tag' => $tagId]);
    }
}