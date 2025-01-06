<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\EmailIsUnique;

class UserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
}
