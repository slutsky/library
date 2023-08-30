<?php

namespace Slutsky\Library\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidationException extends RuntimeException
{
    private ConstraintViolationListInterface $violations;

    public function __construct(
        ConstraintViolationListInterface $violations,
        string $message = '',
        $code = 0,
        ?Throwable $previous = null
    ) {
        $this->violations = $violations;

        parent::__construct($message, $code, $previous);
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
