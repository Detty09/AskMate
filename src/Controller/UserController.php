<?php

namespace App\Controller;

use App\Http\SuperGlobalManager;
use App\Model\User;
use App\Repository\UserRepository;
use eftec\bladeone\BladeOne;
use JetBrains\PhpStorm\NoReturn;

class UserController
{
    private BladeOne $blade;
    private UserRepository $userRepository;

    public function __construct(BladeOne $blade, UserRepository $userRepository)
    {
        $this->blade = $blade;
        $this->userRepository = $userRepository;
    }

    public function create(): void
    {
        echo $this->blade->run('register');
    }

    public function store(): void
    {
        $email = $_POST['email'];
        $confirmEmail = $_POST['email_confirmation'];

        if ($email !== $confirmEmail) {
            echo $this->blade->run("register", ['error' => 'Emails do not match']);
            die();
        } else {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user = new User($email, $password);

            $this->userRepository->save($user);

            http_response_code(201);
            echo $this->blade->run("home", ['name' => 'Guest']);
        }
    }

    public function loginPage(): void
    {
        echo $this->blade->run("login");
    }

    public function login(): string
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        //Fetch user from DB
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            echo $this->blade->run("login", ['error' => 'Invalid email or password']);
            die();
        }
        //verify pw
        if (password_verify($password, $user->password_hash)) {
            session_regenerate_id();

            SuperGlobalManager::setSession('user_id', $user->id);
            SuperGlobalManager::setSession('email', $user->email);

            header('Location: /');
            exit;
        } else {
            echo $this->blade->run("login", ['error' => 'Invalid email or password']);
        }
        return '';
    }

    #[NoReturn]
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();

        header('Location: /');
        exit;
    }

    public function index(): void
    {
        if (SuperGlobalManager::hasSession('user_id')) {
            $data = $this->userRepository->findAll();
            $users = [];

            foreach ($data as $user) {
                $users[] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'registration_date' => $user['registration_time'],
                    'questions' => $user['questions'] ?? 0,
                    'answers' => $user['answers'] ?? 0,
                ];
            }

            echo $this->blade->run("users", ['users' => $users]);
        } else {
            echo $this->blade->run('login', ['error' => 'You need to be logged in to access this page']);
        }
    }
}