<?php

namespace Slutsky\Library\Service;

use Slutsky\Library\Dto\FileUpload;
use Slutsky\Library\Exception\FileUploadValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FileUploadValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws FileUploadValidationException
     */
    public function validate(FileUpload $bookChange): void
    {
        $violations = $this->validator->validate($bookChange);

        if ($violations->count() > 0) {
            throw FileUploadValidationException::validationFailed($violations);
        }
    }
}
