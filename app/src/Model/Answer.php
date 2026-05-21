<?php

namespace App\Model;

class Answer
{
    public int $id_registered_user;
    public int $id_question;
    public string $message;
    public int $vote_number;

    public function __construct(int $id_registered_user, int $id_question, string $message, int $vote_number = 0) {
        $this->id_registered_user = $id_registered_user;
        $this->id_question = $id_question;
        $this->message = $message;
        $this->vote_number = $vote_number;
    }
}