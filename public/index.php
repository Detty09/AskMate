<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Http\Router;
use App\View\BladeFactory;
use App\Security\FilterManager;
use App\Http\SuperGlobalManager;

$pdo = \App\Database\Connection::getConnection();
$repository = new \App\Classes\Question($pdo);
$QuestionController = new \App\Controllers\QuestionController($repository);

session_start();

$blade = BladeFactory::getBlade();

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
    global $QuestionController;
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    echo $QuestionController->show($blade, $id);
});

$router->post("/submit", function() use ($blade) {
    $value = SuperGlobalManager::getRequest("value", "default");
    SuperGlobalManager::setSession("submitted value", $value);
    echo "Form submitted! You sent: " . htmlspecialchars($value);
});
$router->dispatch($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);