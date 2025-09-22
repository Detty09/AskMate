<?php

namespace App\Repository;

use App\Model\Question;
use App\Repository\RepositoryInterface;
use PDO;
class QuestionRepository implements RepositoryInterface {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    public function find(int $id): ?object
    {
        $sql = 'SELECT * FROM question  WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ?: null;
    }


    public function save(object $entity): void
    {
        if (!$entity instanceof Question) {
            throw new \InvalidArgumentException("Expected a Question instance");
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO question (id_registered_user, title, message, vote_number) 
            VALUES (:id_registered_user, :title, :message, :vote_number)");

        $stmt->execute([
            "id_registered_user" => $entity->id_registered_user,
            "title" => $entity->title,
            "message" => $entity->message,
            "vote_number" => $entity->vote_number
        ]);
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