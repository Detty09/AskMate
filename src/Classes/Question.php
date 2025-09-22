<?php

namespace App\Classes;

use App\Repository\RepositoryInterface;
use PDO;

class Question
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $id): ?object
    {
        $sql = 'SELECT * FROM question  WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

       $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ?: null;
    }

}