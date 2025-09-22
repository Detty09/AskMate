<?php

namespace App\Controllers;

use App\Classes\Question;

class QuestionController
{
    private Question $repository;

    public function __construct(Question $repository) {
        $this->repository = $repository;
    }

    public function show($blade, int $id): string
    {
       $question = $this->repository->find($id);
        if (!$question) {
            http_response_code(404);
            return $blade->run('displayquestion', ['question' => null]);
        }
        return $blade->run('displayquestion', ['question' => $question]);
    }


}