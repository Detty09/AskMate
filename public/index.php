<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Http\Router;
use App\View\BladeFactory;
use App\Security\FilterManager;
use App\Http\SuperGlobalManager;
use App\Controller\FormController;

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

$formController = new FormController();
$router->get("/add-question", [$formController, "showForm"]);
$router->post("/submit-question", [$formController, "submitQuestion"]);


$router->dispatch($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);