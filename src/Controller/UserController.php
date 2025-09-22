<?php

namespace App\Controller;

use App\Repository\UserRepository;
use eftec\bladeone\BladeOne;

class UserController
{
    private BladeOne $view;
    private UserRepository $userRepository;

    public function __construct(BladeOne $view, UserRepository $userRepository) {
        $this->view = $view;
        $this->userRepository = $userRepository;
    }

    public function create(): string
    {
        return $this->view->run('register');
    }

    public function store(): void {

    }
    
    public function login(): string {
        
    }
}