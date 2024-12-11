<?php

namespace App\Components\User\Persistence;

use App\Components\User\Persistence\Mapper\UserMapper;
use App\DataTransferObjects\UserDTO;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly UserMapper $userMapper,
    ) {
        parent::__construct($registry, User::class);
    }

    public function getUserByEmail(string $email): ?UserDTO
    {
        $userEntity = $this->findOneBy(['email' => $email]);

        if (null !== $userEntity) {
            return $this->userMapper->entityToDTO($userEntity);
        }

        return null;
    }
}
