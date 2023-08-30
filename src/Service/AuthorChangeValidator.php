<?php

namespace Slutsky\Library\Service;

use Slutsky\Library\Dto\AuthorChange;
use Slutsky\Library\Exception\AuthorChangeValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthorChangeValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws AuthorChangeValidationException
     */
    public function validate(AuthorChange $authorChange): void
    {
        $violations = $this->validator->validate($authorChange);

        if ($violations->count() > 0) {
            throw AuthorChangeValidationException::validationFailed($violations);
        }
    }
}
