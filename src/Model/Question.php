<?php

namespace App\Model;

use PDO;

class Question {
    private PDO $pdo;

    public int $id_registered_user;
    public string $title;
    public string $message;
    public int $vote_number = 0;


    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function save(): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO question (id_registered_user, title, message, vote_number) 
            VALUES (:id_registered_user, :title, :message, :vote_number)");

        $stmt->execute([
            "id_registered_user" => $this->id_registered_user,
            "title" => $this->title,
            "message" => $this->message,
            "vote_number" => $this->vote_number
        ]);
    }
}