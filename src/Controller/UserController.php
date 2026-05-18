<?php

namespace App\Controller;

use App\Http\SuperGlobalManager;
use App\Model\User;
use App\Repository\UserRepository;
use eftec\bladeone\BladeOne;
use JetBrains\PhpStorm\NoReturn;
use App\Service\UserService;

class UserController
{
    private BladeOne $blade;
    private UserService $userService;

    public function __construct(BladeOne $blade, UserService $userService)
    {
        $this->blade = $blade;
        $this->userService = $userService;
    }

    public function create(): void
    {
        echo $this->blade->run('register');
    }

    public function store(): void
    {
        try {
            $this->userService->register($_POST);

            header('Location: /login');
            exit;
        } catch (\Exception $e) {

            echo $this->blade->run('register', [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function loginPage(): void
    {
        echo $this->blade->run("login");
    }

    public function login(): void
    {
        try {

            $this->userService->login($_POST);

            header('Location: /');
            exit;
        } catch (\Exception $e) {

            echo $this->blade->run('login', [
                'error' => $e->getMessage()
            ]);
        }
    }

    #[NoReturn]
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();

        header('Location: /');
        exit;
    }

    public function update(): void
    {
        $userId = SuperGlobalManager::getSession('user_id');

        if (!$userId) {
            echo $this->blade->run('login', [
                'error' => 'You need to be logged in'
            ]);
            return;
        }

        try {
            $this->userService->updateUser($userId, $_POST);

            header('Location: /users');
            exit;
        } catch (\Exception $e) {

            $user = $this->userService->getUser($userId);

            echo $this->blade->run('edit-user', [
                'error' => $e->getMessage(),
                'user' => $user
            ]);
        }
    }

    public function delete(): void
    {
        try {

            $userId = SuperGlobalManager::getSession('user_id');

            $this->userService->deleteUser($userId);

            header('Location: /logout');
            exit;
        } catch (\Exception $e) {

            echo $this->blade->run('users', [
                'error' => $e->getMessage(),
                'users' => $this->userService->getUsers()
            ]);
        }
    }

    public function index(): void
    {
        if (!SuperGlobalManager::hasSession('user_id')) {

            echo $this->blade->run('login', [
                'error' => 'You need to be logged in'
            ]);

            return;
        }

        $users = $this->userService->getUsers();

        echo $this->blade->run('users', [
            'users' => $users
        ]);
    }
}
