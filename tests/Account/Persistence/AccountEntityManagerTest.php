<?php
declare(strict_types=1);

namespace App\Tests\Account\Persistence;

use App\Components\Account\Persistence\AccountEntityManager;
use App\DataTransferObjects\TransferDTO;
use App\Entity\User;
use App\Tests\Config;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AccountEntityManagerTest extends KernelTestCase
{
    private AccountEntityManager $accountEntityManager;
    private ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $container = static::getContainer();
        $this->entityManager = $container->get(EntityManagerInterface::class);
        $this->accountEntityManager = $container->get(AccountEntityManager::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testAddSuccessful(): void
    {
        $user = new User();
        $user->setName(Config::USER_NAME_ONE);
        $user->setEmail(Config::USER_EMAIL_ONE);
        $user->setPassword(Config::USER_PASSWORD);
        $transferDTO = new TransferDTO(
            1,
            10.0,
            '2024-08-22'
        );

        $this->accountEntityManager->add($user, $transferDTO);

    }
}