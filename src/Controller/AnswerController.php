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
        $userId = SuperGlobalManager::getSession("user_id");
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

    public function editAnswer($blade, int $id): string
    {
        $answer = $this->repository->find($id);
        if (!$answer) {
            http_response_code(404);
            return $blade->run('answer-edit', ['answer' => null]);
        }
        return $blade->run('answer-edit', ['answer' => $answer]);
    }

    public function updateAnswer(): void {
        $id = SuperGlobalManager::getRequest("id");
        $message = SuperGlobalManager::getRequest("answer-message");
        $answer = $this->repository->find($id);
        $answer->message = $message;
        $this->repository->update($answer);
    header("Location: /display?id={$answer->id_question}");
    exit;
    }

    public function deleteAnswer(): void {
        $id = SuperGlobalManager::getRequest("id");
        $answer = $this->repository->find($id);
        $this->repository->delete($answer->id);
        header("Location: /display?id={$answer->id_question}");
        exit;
    }

}