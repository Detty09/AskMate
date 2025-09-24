<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\AnswerController;
use App\Controller\FormController;
use App\Controller\TagController;
use App\Controller\UserController;
use App\Controller\QuestionController;
use App\Controller\QuestionsController;
use App\Database\Connection;
use App\Http\Router;
use App\Http\SuperGlobalManager;
use App\Model\User;
use App\Repository\QuestionTagRelationRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Repository\QuestionRepository;
use App\Repository\AnswerRepository;
use App\Security\FilterManager;
use App\View\BladeFactory;


session_start();
$pdo = Connection::getConnection();
$blade = BladeFactory::getBlade();
$userRepository = new UserRepository($pdo);
$questionRepository = new QuestionRepository($pdo);
$answerRepository = new AnswerRepository($pdo);
$tagRepository = new TagRepository($pdo);
$questionTagRelationRepository = new QuestionTagRelationRepository($pdo);

$userController = new UserController($blade ,$userRepository);
$questionController = new QuestionController($blade, $questionRepository, $answerRepository, $tagRepository, $questionTagRelationRepository);
$AnswerController = new AnswerController($blade, $answerRepository);
$tagController = new TagController($blade, $tagRepository, $questionRepository, $questionTagRelationRepository);

$filter = new FilterManager([
    "methods" => ["GET", "POST"],
    "ips" => [],
    "browsers" => ["Chrome", "Firefox"]
]);

if (!$filter->checkAll($_SERVER["REQUEST_METHOD"], $_SERVER["REMOTE_ADDR"], $_SERVER["HTTP_USER_AGENT"])) {
    http_response_code(403);
    die("Access denied");
}

$router = new Router();

$router->get("/", function() use ($blade, $questionController) {
    echo $questionController->index();
});

$router->get("/display", function() use ($blade, $questionController) {
    if (!isset($_GET['id']) || !is_numeric($_GET['id']) || (int)$_GET['id'] <= 0) {
        http_response_code(404);
        echo $blade->run('displayquestion', ['question' => null, 'answers' => []]);
        return;
    }

    $id = (int)$_GET['id'];
    echo $questionController->show($blade, $id);
});

$router->get("/add-answer", function() use ($blade, $questionController) {
    $id = $_SESSION['current_id_question'] ?? 0;

    if ($id <= 0 || !$questionController->show($blade, (int)$id)) {
        http_response_code(404);
        echo $blade->run('displayquestion', ['question' => null, 'answers' => []]);
        return;
    }

    echo $blade->run('answer_form', ['id_question' => $id]);
});

$router->post("/submit-answer", [$AnswerController, "submitAnswer"]);

$router->get("/answer-edit", function() use ($blade, $AnswerController) {
    $answerId = (int) SuperGlobalManager::getRequest("id");
    if (!$answerId) {
        http_response_code(404);
        echo $blade->run('displayquestion', ['question' => null, 'answers' => []]);
        return;
    }
    echo $AnswerController->editAnswer($answerId);
});

$router->post("/answer-update", [$AnswerController, "updateAnswer"]);
$router->post("/answer-delete", [$AnswerController, "deleteAnswer"]);

$router->post("/submit", function() use ($blade, $questionController, $AnswerController) {
    $searchTerm = SuperGlobalManager::getRequest("value", "");
    $name = $_SESSION['email'] ?? "Guest";
    $questions = $questionController->search($searchTerm);
    $answers = $AnswerController->search($searchTerm);
  echo $blade->run('search', ['questions' => $questions, 'answers'=>$answers, 'name'=>$name, 'query' => $searchTerm]);
});

//Add question
$router->get("/add-question", [$questionController, "showNewQuestionForm"]);
$router->post("/submit-question", [$questionController, "submitQuestion"]);

//My questions
$router->get("/my-questions", [$questionController, "listUserQuestions"]);

//Delete question
$router->post("/delete-question", [$questionController, "deleteQuestion"]);

//Update question
$router->get("/edit-question", [$questionController, "showUpdateQuestionForm"]);
$router->post("/update-question", [$questionController, "updateQuestion"]);

//Register
$router->get("/register", [$userController, 'create']);
$router->post("/register", [$userController, 'store']);

//Login / Logout
$router->get('/login', [$userController, 'loginPage']);
$router->post('/login', [$userController, 'login']);
$router->get("/logout", [$userController, 'logout']);

//User List
$router->get('/users', [$userController, 'index']);

//Tag List
$router->get('/tags', [$tagController, 'index']);
$router->post('/tags', [$tagController, 'store']);

//Vote
$router->get('/question/vote', function() use ($questionController) {
    $questionController->vote();
});

$router->dispatch($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);