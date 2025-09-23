<?php

namespace App\Repository;

use App\Model\Answer;
use App\Model\Question;
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

    public function find(int $id): ?object
    {
        $sql = 'SELECT * FROM answer  WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ?: null;
    }

    public function save(object $entity): int
    {
        if (!$entity instanceof Answer) {
            throw new \InvalidArgumentException("Expected an Answer instance");
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO answer (id_registered_user, id_question, message, vote_number) 
            VALUES (:id_registered_user, :id_question, :message, :vote_number)");

        $stmt->execute([
            "id_registered_user" => $entity->id_registered_user,
            "id_question" => $entity->id_question,
            "message" => $entity->message,
            "vote_number" => $entity->vote_number
        ]);

        return $this->pdo->lastInsertId();
    }

    public function update(object $entity): void
    {

        $sql = 'UPDATE answer SET message = :message, vote_number = :vote_number WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['message' => $entity->message, 'vote_number' => $entity->vote_number,'id' => $entity->id]);
    }

    public function delete(int $id): void
    {
        $sql = 'DELETE FROM answer WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}