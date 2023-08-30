<?php

namespace Slutsky\Library\Dto;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class FileUpload
{
    /**
     * @Assert\NotBlank
     */
    private $file;

    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public static function fromFile(?UploadedFile $file): self
    {
        $self = new self();

        if (null !== $file) {
            $self->setFile($file);
        }

        return $self;
    }
}
