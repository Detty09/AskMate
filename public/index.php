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
    $name = $_SESSION['email'] ?? "Guest";
    echo $blade->run("home", ["name" => $name]);
});

$router->get("/display", function() use ($blade) {
    global $QuestionController, $answerRepository;
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    echo $QuestionController->show($id, $answerRepository);
});

//Add question
$router->get("/add-question", [$formController, "showForm"]);
$router->post("/submit-question", [$formController, "submitQuestion"]);

//Register
$router->get("/register", function () use ($blade) {
    echo $blade->run("register");
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

//Login
$router->get('/login', function() use ($blade) {
    echo $blade->run("login");
});

$router->post("/login", function() use ($blade, $userRepository) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Fetch user from DB
    $user = $userRepository->findByEmail($email);
    if (!$user) {
        echo $blade->run("login", ['error' => 'Invalid email or password']);
        return;
    }
    //verify pw
    if (password_verify($password, $user->password_hash)) {
        session_regenerate_id();
        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;

        header('Location: /home');
        exit;
    } else {
        echo $blade->run("login", ['error' => 'Invalid email or password']);
    }
});

$router->get("/logout", function() use ($blade) {
    unset($_SESSION['user_id']);
    unset($_SESSION['email']);
    header('Location: /home');
    session_destroy();
    exit;
});

//My questions
//$router->get("/my-questions", [$QuestionController, "listUserQuestions"] );

$router->dispatch($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);