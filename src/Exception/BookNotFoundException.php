<?php

namespace Slutsky\Library\Exception;

class BookNotFoundException extends NotFoundException
{
    public const MESSAGE = 'Book not found';

    public static function create(): self
    {
        return new self(self::MESSAGE);
    }
}
