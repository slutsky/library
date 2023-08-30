<?php

namespace Slutsky\Library\Exception;

class AuthorNotFoundException extends NotFoundException
{
    public const MESSAGE = 'Author not found';

    public static function create(): self
    {
        return new self(self::MESSAGE);
    }
}
