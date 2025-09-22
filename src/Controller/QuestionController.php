<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use App\Repository\AnswerRepository;

class QuestionController
{
    private QuestionRepository $repository;
    private AnswerRepository $answerRepository;

    public function __construct(QuestionRepository $repository, AnswerRepository $answerRepository) {
        $this->repository = $repository;
        $this->answerRepository = $answerRepository;
    }

    public function show($blade, int $id, AnswerRepository $answerRepository): string
    {
       $question = $this->repository->find($id);
        if (!$question) {
            http_response_code(404);
            return $blade->run('displayquestion', ['question' => null]);
        }
        $answers = $answerRepository->findByQuestionId($id);
        return $blade->run('displayquestion', ['question' => $question
        , 'answers' => $answers]);
    }


}