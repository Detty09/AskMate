<?php

namespace App\Controller;

use App\Database\Connection;
use App\Repository\QuestionRepository;
use App\Repository\AnswerRepository;
use App\Http\SuperGlobalManager;
use App\View\BladeFactory;
use eftec\bladeone\BladeOne;

class QuestionController
{
    private BladeOne $blade;

    private QuestionRepository $repository;
    private AnswerRepository $answerRepository;

    public function __construct(BladeOne $blade, QuestionRepository $repository, AnswerRepository $answerRepository) {
        $this->blade = $blade;
        $this->repository = $repository;
        $this->answerRepository = $answerRepository;
    }

    public function show($blade, int $id): string
    {
       $question = $this->repository->find($id);
        if (!$question) {
            http_response_code(404);
            return $blade->run('displayquestion', ['question' => null, 'answers' => []]);
        }
        $_SESSION['current_id_question'] = $id;
        $answers = $this->answerRepository->findByQuestionId($id);
        return $blade->run('displayquestion', ['question' => $question
        , 'answers' => $answers]);
    }

    public function search(string $searchTerm): ?array {
        $searchTerm = trim($searchTerm);
        if (empty($searchTerm)) {
            return null;
        }
        $questions = $this->repository->search($searchTerm);
        if(empty($questions)) {
            return null;
        }
        return $questions;
    }

    /*
    public function listUserQuestions(): void {
        $userId = SuperGlobalManager::getSession("user_id");
        if (!$userId) {
            header("Location: /home");
            exit;
        }

        $questions = $this->repository->findByUser($userId);

        echo $this->blade->run();
    }

    */
}