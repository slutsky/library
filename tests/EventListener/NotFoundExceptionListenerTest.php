<?php

namespace Slutsky\Library\Tests\Entity;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Slutsky\Library\EventListener\NotFoundExceptionListener;
use Slutsky\Library\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class NotFoundExceptionListenerTest extends TestCase
{
    private const SERIALIZED = 'Serialized text';

    private NotFoundExceptionListener $listener;

    protected function setUp(): void
    {
        /**
         * @var MockObject&SerializerInterface
         */
        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->method('serialize')->willReturn(self::SERIALIZED);

        $this->listener = new NotFoundExceptionListener($serializer);
    }

    public function testOnNotFoundException(): void
    {

        $event = new ExceptionEvent(
            $this->createStub(HttpKernelInterface::class),
            $this->createStub(Request::class),
            0,
            $this->createStub(NotFoundException::class),
        );

        $this->listener->onException($event);

        $this->assertNotNull($event->getResponse());
        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $event->getResponse()->getStatusCode()
        );
    }

    public function testOnNotFoundExceptionWithWrongException(): void
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
