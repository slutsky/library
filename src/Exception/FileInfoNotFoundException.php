<?php

namespace Slutsky\Library\Exception;

class FileInfoNotFoundException extends NotFoundException
{
    public const MESSAGE = 'File not found';

    public static function create(): self
    {
        return new self(self::MESSAGE);
    }
}
