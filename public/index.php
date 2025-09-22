<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\FormController;
use App\Controller\UserController;
use App\Database\Connection;
use App\Http\Router;
use App\Http\SuperGlobalManager;
use App\Model\User;
use App\Repository\UserRepository;
use App\Security\FilterManager;
use App\View\BladeFactory;

$pdo = \App\Database\Connection::getConnection();
$repository = new \App\Repository\QuestionRepository($pdo);
$answerRepository = new \App\Repository\AnswerRepository($pdo);
$QuestionController = new \App\Controller\QuestionController($repository, $answerRepository);

session_start();

$blade = BladeFactory::getBlade();
$userRepository = new UserRepository(Connection::getConnection());
$userController = new UserController($blade, $userRepository);

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
    $name = "Boti";
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

//Register
$router->get("/register", function () use ($blade) {
    echo $blade->run("register");
    });

$router->post("/submit", function() use ($blade) {
    $value = SuperGlobalManager::getRequest("value", "default");
    SuperGlobalManager::setSession("submitted value", $value);
    echo "Form submitted! You sent: " . htmlspecialchars($value);
});

$router->post("/register", function() use ($blade, $userRepository) {
    $email = $_POST['email'];
    $confirmEmail = $_POST['email_confirmation'];

    if ($email !== $confirmEmail) {
        echo 'Emails do not match';
        return;
    }

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user = new User($email, $password);

    $userRepository->save($user);

    echo $blade->run("home");
});


$router->dispatch($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);