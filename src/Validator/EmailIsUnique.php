<?php

declare(strict_types=1);

namespace App\Validator;

use Composer\Semver\Constraint\Constraint;

/**
 * @Annotation
 */
class EmailIsUnique extends Constraint
{
    public string $message = 'The email "{{ value }}" is already in use';
}
