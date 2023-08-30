<?php

namespace Slutsky\Library\Service;

use Slutsky\Library\Dto\BookChange;
use Slutsky\Library\Exception\BookChangeValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookChangeValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws BookChangeValidationException
     */
    public function validate(BookChange $bookChange): void
    {
        $violations = $this->validator->validate($bookChange);

        if ($violations->count() > 0) {
            throw BookChangeValidationException::validationFailed($violations);
        }
    }
}
