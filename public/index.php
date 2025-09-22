<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\UserController;
use App\Database\Connection;
use App\Http\Router;
use App\Model\User;
use App\Repository\UserRepository;
use App\View\BladeFactory;
use App\Security\FilterManager;
use App\Http\SuperGlobalManager;
use App\Controller\FormController;

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


$formController = new FormController();
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


$router->dispatch($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);