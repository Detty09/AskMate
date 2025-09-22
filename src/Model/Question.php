<?php

namespace App\Model;

class Question {

    public int $id_registered_user;
    public string $title;
    public string $message;
    public int $vote_number;

    public function __construct(int $id_registered_user, string $title, string $message, int $vote_number = 0) {
        $this->id_registered_user = $id_registered_user;
        $this->title = $title;
        $this->message = $message;
        $this->vote_number = $vote_number;
    }
}