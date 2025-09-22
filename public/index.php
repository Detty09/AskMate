<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\FormController;
use App\Database\Connection;
use App\Http\Router;
use App\Http\SuperGlobalManager;
use App\Security\FilterManager;
use App\View\BladeFactory;

$QuestionController = new \App\Controller\QuestionController();
$AnswerController = new \App\Controller\AnswerController();

session_start();

$blade = BladeFactory::getBlade();
$userRepository = new \App\Repository\UserRepository($pdo);
$userController = new \App\Controller\UserController($blade ,$userRepository);

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

$router->get("/home", function() use ($blade) {
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

$formController = new FormController();
$router->get("/add-question", [$formController, "showForm"]);
$router->post("/submit-question", [$formController, "submitQuestion"]);

$router->post("/submit", function() use ($blade) {
    $value = SuperGlobalManager::getRequest("value", "default");
    SuperGlobalManager::setSession("submitted value", $value);
    echo "Form submitted! You sent: " . htmlspecialchars($value);
});

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