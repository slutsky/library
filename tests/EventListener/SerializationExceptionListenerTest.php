<?php

namespace Slutsky\Library\Tests\Entity;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Slutsky\Library\EventListener\SerializationExceptionListener;
use Slutsky\Library\Exception\SerializationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class SerializationExceptionListenerTest extends TestCase
{
    private const SERIALIZED = 'Serialized text';

    private SerializationExceptionListener $listener;

    protected function setUp(): void
    {
        /**
         * @var MockObject&SerializerInterface
         */
        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->method('serialize')->willReturn(self::SERIALIZED);

        $this->listener = new SerializationExceptionListener($serializer);
    }

    public function testOnSerializationException(): void
    {

        $event = new ExceptionEvent(
            $this->createStub(HttpKernelInterface::class),
            $this->createStub(Request::class),
            0,
            $this->createStub(SerializationException::class),
        );

        $this->listener->onException($event);

        $this->assertNotNull($event->getResponse());
        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $event->getResponse()->getStatusCode()
        );
    }

    public function testOnSerializationExceptionWithWrongException(): void
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
