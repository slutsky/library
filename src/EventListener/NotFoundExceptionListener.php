<?php

namespace Slutsky\Library\EventListener;

use Slutsky\Library\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class NotFoundExceptionListener implements ExceptionListenerInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof NotFoundException) {
            return;
        }

        $serialized = $this->serializer->serialize($exception, JsonEncoder::FORMAT);

        $response = new JsonResponse($serialized, Response::HTTP_NOT_FOUND, [], true);

        $event->setResponse($response);
    }
}
