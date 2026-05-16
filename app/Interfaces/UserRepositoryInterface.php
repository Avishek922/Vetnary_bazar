<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getUserById($userId);
    public function createUser(array $data);
    public function updateUser($userId, array $newDetails);
    public function deleteUser($userId);
}
