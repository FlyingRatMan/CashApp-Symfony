<?php

declare(strict_types=1);

namespace App\Components\User\Persistence;

use App\DataTransferObjects\UserDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserEntityManager
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(UserDTO $userDTO): void
    {
        $userEntity = new User();
        $userEntity->setName($userDTO->name);
        $userEntity->setEmail($userDTO->email);
        $userEntity->setPassword($userDTO->password);

        $this->entityManager->persist($userEntity);
        $this->entityManager->flush();
    }

    public function updatePassword(UserDTO $userDTO, string $password): void
    {
        $userEntity = $this->entityManager->find(User::class, $userDTO->id);

        if (null === $userEntity) {
            return;
        }

        $userEntity->setPassword(password_hash($password, PASSWORD_DEFAULT));

        $this->entityManager->flush();
    }
}
