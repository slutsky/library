<?php

namespace Slutsky\Library\Tests\Entity;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Slutsky\Library\EventListener\ValidationExceptionListener;
use Slutsky\Library\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class ValidationExceptionListenerTest extends TestCase
{
    private const SERIALIZED = 'Serialized text';

    private ValidationExceptionListener $listener;

    protected function setUp(): void
    {
        /**
         * @var MockObject&SerializerInterface
         */
        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->method('serialize')->willReturn(self::SERIALIZED);

        $this->listener = new ValidationExceptionListener($serializer);
    }

    public function testOnValidationException(): void
    {

        $event = new ExceptionEvent(
            $this->createStub(HttpKernelInterface::class),
            $this->createStub(Request::class),
            0,
            $this->createStub(ValidationException::class),
        );

        $this->listener->onException($event);

        $this->assertNotNull($event->getResponse());
        $this->assertEquals(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $event->getResponse()->getStatusCode()
        );
    }

    public function testOnValidationExceptionWithWrongException(): void
    {
        $event = new ExceptionEvent(
            $this->createStub(HttpKernelInterface::class),
            $this->createStub(Request::class),
            0,
            $this->createStub(Throwable::class),
        );

        $this->listener->onException($event);

        $this->assertNull($event->getResponse());
    }
}
