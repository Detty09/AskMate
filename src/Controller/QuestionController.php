<?php

namespace App\Controller;

use App\Database\Connection;
use App\Model\Question;
use App\Repository\QuestionRepository;
use App\Repository\AnswerRepository;
use App\Http\SuperGlobalManager;
use App\Repository\TagRepository;
use App\View\BladeFactory;
use eftec\bladeone\BladeOne;
use JetBrains\PhpStorm\NoReturn;

class QuestionController
{
    private BladeOne $blade;
    private QuestionRepository $questionRepository;
    private AnswerRepository $answerRepository;
    private TagRepository $tagRepository;

    public function __construct(BladeOne $blade, QuestionRepository $repository, AnswerRepository $answerRepository, TagRepository $tagRepository) {
        $this->blade = $blade;
        $this->questionRepository = $repository;
        $this->answerRepository = $answerRepository;
        $this->tagRepository = $tagRepository;
    }

    public function index() {
        $questions = $this->questionRepository->findAll();
        return $this->blade->run('displayquestions', ['questions' => $questions]);
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
        $tags = $this->tagRepository->findAll();
        echo $this->blade->run("question_form", ['tags' => $tags]);
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
        $tags = $this->tagRepository->findAll();

        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        echo $this->blade->run("question_form", ["question" => $question, "tags" => $tags, 'error' => $error]);
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

    public function vote(): void {
        $id = SuperGlobalManager::getRequest('id');
        $inc = SuperGlobalManager::getRequest('inc');

        if (!$id || !is_numeric($inc)) {
            http_response_code(400);
            echo "Invalid vote request";
            exit;
        }

        $this->questionRepository->increaseVote((int)$id, (int)$inc);
        header("Location: /");
        exit;
    }

}