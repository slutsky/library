<?php

namespace Slutsky\Library\Service;

use Slutsky\Library\Dto\BookChange;
use Slutsky\Library\Exception\BookChangeSerializationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class BookChangeSerializer
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @throws BookChangeSerializationException
     */
    public function deserialize(Request $request): BookChange
    {
        try {
            /**
             * @var BookChange|null $bookChange
             */
            $bookChange = $this->serializer->deserialize(
                $request->getContent(),
                BookChange::class,
                JsonEncoder::FORMAT
            );
        } catch (ExceptionInterface $exception) {
            throw BookChangeSerializationException::deserializationFailed(
                $exception
            );
        }

        if (null === $bookChange) {
            throw BookChangeSerializationException::deserializationFailed();
        }

        return $bookChange;
    }
}
