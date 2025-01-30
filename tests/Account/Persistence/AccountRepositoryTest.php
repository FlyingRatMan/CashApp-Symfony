<?php

declare(strict_types=1);

namespace App\Tests\Account\Persistence;

use App\Components\Account\Persistence\AccountRepository;
use App\DataTransferObjects\TransferDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AccountRepositoryTest extends KernelTestCase
{
    private AccountRepository $accountRepository;
    private ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $container = static::getContainer();
        $this->entityManager = $container->get(EntityManagerInterface::class);
        $this->accountRepository = $container->get(AccountRepository::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testGetAllByUserIDReturnsListOfTransactions(): void
    {
        $user = $this->entityManager->getRepository(User::class)->find(2);
        $actualData = $this->accountRepository->getAllByUserID($user);

        foreach ($actualData as $transaction) {
            $this->assertInstanceOf(TransferDTO::class, $transaction);
            $this->assertSame(10.0, $transaction->amount);
            $this->assertSame('2024-08-22', $transaction->date);
        }
    }

    public function testGetAllByUserIDReturnsEmpty(): void
    {
        $user = $this->entityManager->getRepository(User::class)->find(3);
        $actualData = $this->accountRepository->getAllByUserID($user);

        $this->assertEmpty($actualData);
    }
}
