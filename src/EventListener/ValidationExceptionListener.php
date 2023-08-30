<?php

namespace Slutsky\Library\EventListener;

use Slutsky\Library\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ValidationExceptionListener implements ExceptionListenerInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof ValidationException) {
            return;
        }

        $serialized = $this->serializer->serialize($exception, JsonEncoder::FORMAT);

        $response = new JsonResponse($serialized, Response::HTTP_UNPROCESSABLE_ENTITY, [], true);

        $event->setResponse($response);
    }
}
