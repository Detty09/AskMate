<?php

namespace App\Repository;

interface RepositoryInterface {
    public function findAll(): array;
    public function find(int $id): ?object;
    public function save(object $entity): int;
    public function update(object $entity): void;
    public function delete(int $id): void;
}