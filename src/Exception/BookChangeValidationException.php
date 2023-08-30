<?php

namespace Slutsky\Library\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class BookChangeValidationException extends ValidationException
{
    public const VALIDATION_FAILED_MESSAGE = 'Book change validation failed.';

    public static function validationFailed(ConstraintViolationListInterface $violations): self
    {
        return new self($violations, self::VALIDATION_FAILED_MESSAGE);
    }
}
