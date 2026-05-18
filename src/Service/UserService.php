<?php

namespace App\Service;

use App\Model\User;
use App\Repository\UserRepository;
use App\Http\SuperGlobalManager;

class UserService

{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): void
    {
        $email = trim($data['email']);
        $confirmEmail = trim($data['email_confirmation']);
        $password = $data['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email format');
        }

        if ($email !== $confirmEmail) {
            throw new \Exception('Emails do not match');
        }

        $existingUser = $this->userRepository->findByEmail($email);

        if ($existingUser) {
            throw new \Exception('Email already registered');
        }

        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $user = new User(
            $email,
            $passwordHash
        );

        $this->userRepository->save($user);
    }

    public function login(array $data): void
    {
        $email = trim($data['email']);
        $password = $data['password'];

        $user = $this->userRepository
            ->findByEmail($email);

        if (!$user) {
            throw new \Exception(
                'Invalid email or password'
            );
        }

        if (!password_verify(
            $password,
            $user->getPassword()
        )) {
            throw new \Exception(
                'Invalid email or password'
            );
        }

        session_regenerate_id();

        SuperGlobalManager::setSession(
            'user_id',
            $user->getId()
        );

        SuperGlobalManager::setSession(
            'email',
            $user->getEmail()
        );
    }

    public function getUsers(): array
    {
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

        return $users;
    }

    public function updateUser(
        int $userId,
        array $data
    ): void {

        $loggedInUserId = SuperGlobalManager::getSession('user_id');

        if ($loggedInUserId !== $userId) {
            throw new \Exception(
                'You can only edit your own account'
            );
        }

        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new \Exception('User not found');
        }

        $updatedUser = new User(
            trim($data['email']),
            $user->getPassword(),
            $user->getId()
        );

        $this->userRepository->update($updatedUser);
    }

    public function deleteUser(int $userId): void
    {
        $loggedInUserId = SuperGlobalManager::getSession('user_id');

        if ($loggedInUserId !== $userId) {
            throw new \Exception(
                'You can only delete your own account'
            );
        }

        $this->userRepository->delete($userId);

        session_destroy();
    }

    public function getUser(int $id): ?User
    {
        return $this->userRepository->find($id);
    }
}
