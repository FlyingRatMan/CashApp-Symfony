<?php
declare(strict_types=1);

namespace App\Components\User\Persistence\Mapper;

use App\DataTransferObjects\UserDTO;
use App\Entity\User;

class UserMapper
{
    public function createUserDTO(array $data): UserDTO
    {
        if (!isset($data['id'], $data['name'], $data['email'], $data['password'])) {
            throw new \InvalidArgumentException();
        }

        return new UserDTO($data['id'], $data['name'], $data['email'], $data['password']);
    }

    public function entityToDTO(User $userEntity): UserDTO
    {
        $id = $userEntity->getId();
        $name = $userEntity->getName();
        $email = $userEntity->getEmail();
        $password = $userEntity->getPassword();

        if (!isset($id, $name, $email, $password)) {
            throw new \InvalidArgumentException();
        }

        return new UserDTO(id: $id, name: $name, email: $email, password: $password);
    }
}