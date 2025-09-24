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
    private $blade;

    public function __construct($blade, AnswerRepository $repository)
    {
        $pdo = Connection::getConnection();
        $this->repository = $repository;
        $this->blade = $blade;

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

    public function editAnswer(){
        $answerId = (int) SuperGlobalManager::getRequest("id");
    if (!$answerId) {
        http_response_code(404);
        echo $this->blade->run('displayquestion', ['question' => null, 'answers' => []]);
        exit;
    }
        $answer = $this->repository->find($answerId);
        if (!$answer) {
            http_response_code(404);
            echo $this->blade->run('answer-edit', ['answer' => null]);
        }
        echo $this->blade->run('answer-edit', ['answer' => $answer]);
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

    public function search(string $searchTerm): ?array {
        $searchTerm = trim($searchTerm);
        if (empty($searchTerm)) {
            return null;
        }
     $answers = $this->repository->search($searchTerm);
        if(empty($answers)) {
            return null;
        }
        return $answers;
    }

    public function showAnswerFrom() {
        $id = $_SESSION['current_id_question'] ?? 0;
        if ($id <= 0) {
            http_response_code(404);
            echo $this->blade->run('displayquestion', ['question' => null, 'answers' => []]);
            return;
        }

        echo $this->blade->run('answer_form', ['id_question' => $id]);
    }

    public function vote(): void {
        $id = SuperGlobalManager::getRequest('id');
        $inc = SuperGlobalManager::getRequest('inc');

        if (!$id || !is_numeric($inc)) {
            http_response_code(400);
            echo "Invalid vote request";
            exit;
        }

        $this->repository->increaseVote((int)$id, (int)$inc);
        $answer = $this->repository->find((int)$id);
        $questionId = $answer ? $answer->id_question : 0;

        header("Location: /display?id=$questionId");
        exit;
    }
}