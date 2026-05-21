<?php

namespace App\Repository;

use App\Model\Question;
use App\Repository\RepositoryInterface;
use PDO;
class QuestionRepository {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $sql = 'SELECT * FROM question ORDER BY submission_time DESC';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findByUser(int $userId): ?array {
        $sql = "SELECT * FROM question WHERE id_registered_user = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result ?: null;
    }

    public function find(int $id): ?object
    {
        $sql = 'SELECT * FROM question  WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ?: null;
    }


    public function save(object $entity): int
    {
        if (!$entity instanceof Question) {
            throw new \InvalidArgumentException("Expected a Question instance");
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO question (id_image, id_registered_user, title, message, vote_number) 
            VALUES (:id_image, :id_registered_user, :title, :message, :vote_number)");

        $stmt->execute([
            "id_image" => $entity->imageID,
            "id_registered_user" => $entity->id_registered_user,
            "title" => $entity->title,
            "message" => $entity->message,
            "vote_number" => $entity->vote_number
        ]);

        return $this->pdo->lastInsertId();
    }

    public function update(object $entity): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE question
            SET id_image = :id_image, title = :title, message = :message
            WHERE id = :id
        ");
        $stmt->execute([
            "id" => $entity->id,
            "id_image" => $entity->imageID,
            "title" => $entity->title,
            "message" => $entity->message,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM question WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function search(string $searchTerm): array
    {
        $sql = "SELECT * FROM question WHERE title LIKE :searchTerm OR message LIKE :searchTerm";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['searchTerm' => "%$searchTerm%"]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function increaseVote(int $id, int $increment): void {
        $stmt = $this->pdo->prepare("UPDATE question SET vote_number = vote_number + :increment WHERE id = :id");
        $stmt->execute(['increment' => $increment, 'id' => $id]);
    }
}