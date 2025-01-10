<?php

declare(strict_types=1);

namespace App\Components\User\Persistence;

use App\DataTransferObjects\UserDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserEntityManager
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
    ) {
    }

    public function save(UserDTO $userDTO): void
    {
        $userEntity = new User();
        $userEntity->setName($userDTO->name);
        $userEntity->setEmail($userDTO->email);
        $userEntity->setPassword($userDTO->password);

        // todo not sure if the second validation is a right approach
        $violations = $this->validator->validate($userEntity);

        if (count($violations) > 0) {
            throw new \Exception('Validation failed');
        }

        $this->entityManager->persist($userEntity);
        $this->entityManager->flush();
    }
}
