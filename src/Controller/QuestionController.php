<?php

namespace App\Controller;

use App\Database\Connection;
use App\Model\Question;
use App\Repository\QuestionRepository;
use App\Repository\AnswerRepository;
use App\Http\SuperGlobalManager;
use App\View\BladeFactory;
use eftec\bladeone\BladeOne;
use JetBrains\PhpStorm\NoReturn;

class QuestionController
{
    private BladeOne $blade;
    private QuestionRepository $questionRepository;
    private AnswerRepository $answerRepository;

    public function __construct(BladeOne $blade, QuestionRepository $repository, AnswerRepository $answerRepository) {
        $this->blade = $blade;
        $this->questionRepository = $repository;
        $this->answerRepository = $answerRepository;
    }

    public function show($blade, int $id): string
    {
       $question = $this->questionRepository->find($id);
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
        $questions = $this->questionRepository->search($searchTerm);
        if(empty($questions)) {
            return null;
        }
        return $questions;
    }

    public function listUserQuestions(): void {
        $userId = SuperGlobalManager::getSession("user_id");
        if (!$userId) {
            header("Location: /");
            exit;
        }

        $questions = $this->questionRepository->findByUser($userId);

        echo $this->blade->run("questionlist_user", ['questions' => $questions]);
    }

    public function showNewQuestionForm(): void {
        echo $this->blade->run("question_form");
    }

    public function submitQuestion(): void {
        $title = SuperGlobalManager::getRequest("question-title");
        $message = SuperGlobalManager::getRequest("question-message");
        $userId = SuperGlobalManager::getSession("user_id");

        $question = new Question($userId, $title, $message);
        $this->questionRepository->save($question);

        header("Location: /");
        exit;
    }

    public function showUpdateQuestionForm(): void {
        $id = SuperGlobalManager::getRequest("id");

        $question = $this->questionRepository->find($id);

        echo $this->blade->run("question_form", ["question" => $question]);
    }

    public function updateQuestion(): void {
        $title = SuperGlobalManager::getRequest("question-title");
        $message = SuperGlobalManager::getRequest("question-message");
        $id = SuperGlobalManager::getRequest("question-id");
        $userId = SuperGlobalManager::getSession("user_id");

        $existingQuestion = $this->questionRepository->find($id);

        if (!$existingQuestion) {
            http_response_code(404);
            echo "Question not found";
            return;
        }

        if ($existingQuestion->id_registered_user !== $userId) {
            http_response_code(403);
            echo "You are not allowed to update this question";
            return;
        }

        $updatedQuestion = new Question($userId, $title, $message);
        $updatedQuestion->id = $id;

        $this->questionRepository->update($updatedQuestion);

        header("Location: /my-questions");
        exit;

    }

    public function deleteQuestion(): void {
        $questionId = SuperGlobalManager::getRequest("question_id");
        if (!$questionId) {
            http_response_code(400);
            echo "Bad request missing question ID";
            exit;
        }

        $userId = SuperGlobalManager::getSession("user_id");
        $question = $this->questionRepository->find($questionId);
        if (!$question || $question->id_registered_user != $userId) {
            http_response_code(403);
            echo "Forbidden: You cannot delete this question.";
            exit;
        }
        $this->questionRepository->delete($questionId);
        header("Location: /my-questions");
        exit;
    }

}