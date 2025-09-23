<?php

namespace App\Repository;

use PDO;

class TagRepository implements RepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection){
        $this->connection = $connection;
    }

    public function findAll(): array
    {
        $sql = "SELECT t.id, t.name, COUNT(rel.id_question) AS questions 
                FROM tag t
                LEFT JOIN rel_question_tag rel ON rel.id_tag = t.id
                GROUP BY t.id";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?object
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