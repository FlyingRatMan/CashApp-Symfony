<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

class TransferDTO
{
    public function __construct(
        public int $id,
        public float $amount,
        public string $date,
    ) {
    }
}
