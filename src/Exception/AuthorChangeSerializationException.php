<?php

namespace Slutsky\Library\Exception;

use Throwable;

class AuthorChangeSerializationException extends SerializationException
{
    public const DESERIALIZATION_FAILED_MESSAGE = 'Author change deserialization failed.';

    public static function deserializationFailed(?Throwable $previous = null): self
    {
        return new self(self::DESERIALIZATION_FAILED_MESSAGE, 0, $previous);
    }
}
