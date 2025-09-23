<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\FormController;
use App\Controller\UserController;
use App\Controller\QuestionController;
use App\Database\Connection;
use App\Http\Router;
use App\Http\SuperGlobalManager;
use App\Model\User;
use App\Repository\UserRepository;
use App\Repository\QuestionRepository;
use App\Repository\AnswerRepository;
use App\Security\FilterManager;
use App\View\BladeFactory;



session_start();
$pdo = Connection::getConnection();
$blade = BladeFactory::getBlade();
$questionRepository = new QuestionRepository($pdo);
$answerRepository = new AnswerRepository($pdo);
$QuestionController = new QuestionController($blade, $questionRepository, $answerRepository);

$formController = new FormController($blade, $questionRepository);

$AnswerController = new \App\Controller\AnswerController();

$userRepository = new UserRepository($pdo);
$userController = new UserController($blade ,$userRepository);

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

$router->get("/", function() use ($blade) {
    $name = $_SESSION['email'] ?? "Guest";
    echo $blade->run("home", ["name" => $name]);
});

$router->get("/display", function() use ($blade) {
    global $QuestionController;
    if (!isset($_GET['id']) || !is_numeric($_GET['id']) || (int)$_GET['id'] <= 0) {
        http_response_code(404);
        echo $blade->run('displayquestion', ['question' => null, 'answers' => []]);
        return;
    }

    $id = (int)$_GET['id'];
    echo $QuestionController->show($blade, $id);
});

$router->get("/add-answer", function() use ($blade, $QuestionController) {
    $id = $_SESSION['current_id_question'] ?? 0;

    if ($id <= 0 || !$QuestionController->show($blade, (int)$id)) {
        http_response_code(404);
        echo $blade->run('displayquestion', ['question' => null, 'answers' => []]);
        return;
    }

    echo $blade->run('answer_form', ['id_question' => $id]);
});
$router->post("/submit-answer", [$AnswerController, "submitAnswer"]);

//Add question
$router->get("/add-question", [$formController, "showForm"]);
$router->post("/submit-question", [$formController, "submitQuestion"]);

//My questions
$router->get("/my-questions", [$QuestionController, "listUserQuestions"]);

//Register
$router->get("/register", [$userController, 'create']);
$router->post("/register", [$userController, 'store']);

//Login / Logout
$router->get('/login', [$userController, 'loginPage']);
$router->post('/login', [$userController, 'login']);
$router->get("/logout", [$userController, 'logout']);

//User List
$router->get('/users', [$userController, 'index']);

$router->dispatch($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);