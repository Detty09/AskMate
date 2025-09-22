<?php

namespace App\Controllers;

use App\Classes\Answer;
use App\Classes\Question;

class QuestionController
{
    private Question $repository;
    private Answer $answerRepository;

    public function __construct(Question $repository, Answer $answerRepository) {
        $this->repository = $repository;
        $this->answerRepository = $answerRepository;
    }

    public function show($blade, int $id, Answer $answerRepository): string
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