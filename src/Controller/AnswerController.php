<?php

namespace App\Controller;

use App\Database\Connection;
use App\Http\SuperGlobalManager;
use App\Model\Answer;
use App\Model\Question;
use App\Repository\AnswerRepository;

class AnswerController
{
    private AnswerRepository $repository;

    public function __construct()
    {
        $pdo = Connection::getConnection();
        $this->repository = new AnswerRepository($pdo);

    }

    public function submitAnswer(): void {
        $message = SuperGlobalManager::getRequest("answer-message");
        $userId = 1; //Should be replaced from session
        $questionId = (int) SuperGlobalManager::getRequest("id_question");

        if($questionId <=0 || empty($message)) {
            http_response_code(400);
            echo "Invalid question ID or empty message";
            exit;
        }

        $answer = new Answer($userId, $questionId, $message);
        $this->repository->save($answer);

        header("Location: /display?id=$questionId");
        exit;
    }

}