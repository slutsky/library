<?php

namespace Slutsky\Library\Service;

use Slutsky\Library\Dto\AuthorChange;
use Slutsky\Library\Exception\AuthorChangeSerializationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AuthorChangeSerializer
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @throws AuthorChangeSerializationException
     */
    public function deserialize(Request $request): AuthorChange
    {
        try {
            /**
             * @var AuthorChange|null $authorChange
             */
            $authorChange = $this->serializer->deserialize(
                $request->getContent(),
                AuthorChange::class,
                JsonEncoder::FORMAT
            );
        } catch (ExceptionInterface $exception) {
            throw AuthorChangeSerializationException::deserializationFailed(
                $exception
            );
        }

        if (null === $authorChange) {
            throw AuthorChangeSerializationException::deserializationFailed();
        }

        return $authorChange;
    }
}
