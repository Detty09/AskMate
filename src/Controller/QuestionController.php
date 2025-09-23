<?php

namespace App\Controller;

use App\Database\Connection;
use App\Repository\QuestionRepository;
use App\Repository\AnswerRepository;
use App\Http\SuperGlobalManager;
use App\View\BladeFactory;
use eftec\bladeone\BladeOne;
use JetBrains\PhpStorm\NoReturn;

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


    public function listUserQuestions(): void {
        $userId = SuperGlobalManager::getSession("user_id");
        if (!$userId) {
            header("Location: /");
            exit;
        }

        $questions = $this->repository->findByUser($userId);

        echo $this->blade->run("questionlist_user", ['questions' => $questions]);
    }

    public function deleteQuestion(): void {
        $questionId = SuperGlobalManager::getRequest("question_id");
        if (!$questionId) {
            http_response_code(400);
            echo "Bad request missing question ID";
            exit;
        }

        $userId = SuperGlobalManager::getSession("user_id");
        $question = $this->repository->find($questionId);
        if (!$question || $question->id_registered_user != $userId) {
            http_response_code(403);
            echo "Forbidden: You cannot delete this question.";
            exit;
        }
        $this->repository->delete($questionId);
        header("Location: /my-questions");
        exit;
    }

}