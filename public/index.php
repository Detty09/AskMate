<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\FormController;
use App\Database\Connection;
use App\Http\Router;
use App\Http\SuperGlobalManager;
use App\Security\FilterManager;
use App\View\BladeFactory;

$pdo = \App\Database\Connection::getConnection();
$repository = new \App\Repository\QuestionRepository($pdo);
$answerRepository = new \App\Repository\AnswerRepository($pdo);
$QuestionController = new \App\Controller\QuestionController($repository, $answerRepository);

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
    global $QuestionController, $answerRepository;
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    echo $QuestionController->show($blade, $id, $answerRepository);
});

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