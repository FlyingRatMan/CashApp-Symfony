<?php

declare(strict_types=1);

namespace App\Components\User\Business\Model;

use App\Components\User\Persistence\UserRepository;
use App\DataTransferObjects\UserDTO;

class UserValidation
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function verifyUser(string $email, string $password): ?UserDTO
    {
        $user = $this->repository->getUserByEmail($email);

        if (null === $user) {
            return null;
        }

        return password_verify($password, $user->password) ? $user : null;
    }
}
