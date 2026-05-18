<?php

namespace App\Model;

class User
{
    private ?int $id;
    private string $email;
    private string $password;

     public function __construct(
        string $email,
        string $password,
        ?int $id = null
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}
