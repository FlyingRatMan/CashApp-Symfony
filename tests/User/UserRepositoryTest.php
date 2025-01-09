<?php

declare(strict_types=1);

namespace App\Tests\User;

use App\Components\User\Persistence\UserRepository;
use App\DataFixtures\UserFixtures;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->userRepository = static::getContainer()->get(UserRepository::class);

        $fixture = new UserFixtures(static::getContainer()->get('security.password_hasher'));
        $fixture->load($this->entityManager);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
    }

    public function testGetUserByEmailReturnsUser(): void
    {
        $userEmail = 'user1@example.com';

        $userDTO = $this->userRepository->getUserByEmail($userEmail);

        $this->assertNotNull($userDTO);
        $this->assertEquals($userEmail, $userDTO->email);
    }

    public function testUpgradePasswordSuccess(): void
    {
        $userEmail = 'user2@example.com';
        $newPassword = 'newPass123!';

        $userEntity = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $userEmail]);
        $this->assertNotNull($userEntity);

        $newHashedPassword = static::getContainer()->get('security.password_hasher')->hashPassword($userEntity, $newPassword);
        $this->userRepository->upgradePassword($userEntity, $newHashedPassword);

        $this->entityManager->refresh($userEntity);
        $this->assertEquals($newHashedPassword, $userEntity->getPassword());
    }

    public function testGetUserByEmailReturnsNull(): void
    {
        $nonExistentEmail = 'nonexistent@example.com';

        $userDTO = $this->userRepository->getUserByEmail($nonExistentEmail);

        $this->assertNull($userDTO);
    }
}
