<?php

namespace Slutsky\Library\Tests\Entity;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Slutsky\Library\Dto\AuthorChange;
use Slutsky\Library\Exception\AuthorChangeSerializationException;
use Slutsky\Library\Service\AuthorChangeSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AuthorChangeSerializerTest extends TestCase
{
    /**
     * @var Stub&Request
     */
    private Stub $request;

    /**
     * @var Stub&AuthorChange
     */
    private Stub $authorChange;

    /**
     * @var MockObject&SerializerInterface
     */
    private MockObject $serializer;

    private AuthorChangeSerializer $authorChangeSerializer;

    protected function setUp(): void
    {
        $this->request = $this->createStub(Request::class);

        $this->authorChange = $this->createStub(AuthorChange::class);

        $this->serializer = $this->createMock(SerializerInterface::class);

        $this->authorChangeSerializer = new AuthorChangeSerializer(
            $this->serializer
        );
    }

    public function testDeserialize(): void
    {
        $this->serializer->method('deserialize')
            ->willReturn($this->authorChange);

        $authorChange = $this->authorChangeSerializer->deserialize(
            $this->request
        );

        $this->assertSame($this->authorChange, $authorChange);
    }

    public function testDeserializeWhenSerializerThrowException(): void
    {
        $this->expectDeserializationFailedException();

        $this->serializer->method('deserialize')->willThrowException(
            $this->createStub(ExceptionInterface::class)
        );

        $this->authorChangeSerializer->deserialize($this->request);
    }

    public function testDeserializeWhenSerializerReturnNull(): void
    {
        $this->expectDeserializationFailedException();

        $this->serializer->method('deserialize')->willReturn(null);

        $this->authorChangeSerializer->deserialize($this->request);
    }

    private function expectDeserializationFailedException(): void
    {
        $this->expectException(AuthorChangeSerializationException::class);
        $this->expectExceptionMessage(
            AuthorChangeSerializationException::DESERIALIZATION_FAILED_MESSAGE
        );
    }
}
