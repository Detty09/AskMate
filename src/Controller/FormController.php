<?php

namespace App\Controller;

use App\View\BladeFactory;
use App\Http\SuperGlobalManager;
use App\Database\Connection;
use App\Model\Question;

class FormController {

    private $blade;

    public function __construct() {
        $this->blade = BladeFactory::getBlade();
    }

    public function showForm(): void {
        echo $this->blade->run("question_form");
    }

    public function submitQuestion(): void {

        $pdo = Connection::getConnection();

        $question = new Question($pdo);
        $question->id_registered_user = 1;
        $question->title = SuperGlobalManager::getRequest("question-title");
        $question->message = SuperGlobalManager::getRequest("question-message");

        $question->save();

        header("Location: /home");
        exit;
    }
}