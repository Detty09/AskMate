<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
class QuestionsController
{
    private QuestionRepository $repository;
    public function __construct(QuestionRepository $repository) {
        $this->repository = $repository;
    }

    public function show($blade): string
    {
        $questions = $this->repository->findAll();
        return $blade->run('question', ['questions' => $questions]);
    }

}