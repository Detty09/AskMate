<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use App\View\BladeFactory;
use App\Http\SuperGlobalManager;
use App\Database\Connection;
use App\Model\Question;

class FormController {

    private $blade;
    private QuestionRepository $questionRepository;

    public function __construct() {
        $this->blade = BladeFactory::getBlade();
        $pdo = Connection::getConnection();
        $this->questionRepository = new QuestionRepository($pdo);
    }

    public function showForm(): void {
        echo $this->blade->run("question_form");
    }

    public function submitQuestion(): void {
        $title = SuperGlobalManager::getRequest("question-title");
        $message = SuperGlobalManager::getRequest("question-message");
        $userId = SuperGlobalManager::getSession("user_id");

        $question = new Question($userId, $title, $message);
        $this->questionRepository->save($question);

        header("Location: /home");
        exit;
    }
}