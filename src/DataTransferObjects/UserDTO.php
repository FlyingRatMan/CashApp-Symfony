<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Validator as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;

class UserDTO
{
    public function __construct(
        public int $id,

        /**
         * @Assert\NotBlank(message="Name is required")
         */
        public string $name,

        /**
         * @Assert\Email(message="Please enter a valid email address")
         *
         * @Assert\NotBlank(message="Email is required")
         */
        public string $email,

        /**
         * @Assert\NotBlank(message="Password is required")
         *
         * @Assert\Regex(
         *      pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/",
         *      message="Password must contain at least one lowercase letter, one uppercase letter, one number, and one special character"
         */
        public string $password,
    ) {
    }
}
