<?php

declare(strict_types=1);

namespace App\Components\Account\Business;

use App\Components\Account\Persistence\AccountRepository;
use App\Entity\User;

class AccountService
{
    public function __construct(
        private AccountRepository $accountRepository,
    ) {
    }

    public function getBalance(User $user): float
    {
        $balance = 0;
        $transactions = $this->accountRepository->getAllByUserID($user);

        foreach ($transactions as $transaction) {
            $balance += $transaction->amount;
        }

        return  $balance;
    }
}
