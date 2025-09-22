<?php

namespace App\Controller;

use App\Database\Connection;
use App\Repository\QuestionRepository;
use App\Repository\AnswerRepository;

class QuestionController
{
    private QuestionRepository $repository;
    private AnswerRepository $answerRepository;

    public function __construct() {
        $pdo = Connection::getConnection();
        $this->repository = new QuestionRepository($pdo);
        $this->answerRepository = new AnswerRepository($pdo);
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


}