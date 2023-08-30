<?php

namespace Slutsky\Library\Tests\Entity;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Slutsky\Library\Dto\AuthorChange;
use Slutsky\Library\Exception\AuthorChangeValidationException;
use Slutsky\Library\Service\AuthorChangeValidator;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthorChangeValidatorTest extends TestCase
{
    /**
     * @var Stub&AuthorChange
     */
    private Stub $authorChange;

    /**
     * @var MockObject&ConstraintViolationListInterface
     */
    private MockObject $violation;

    private AuthorChangeValidator $authorChangeValidator;

    protected function setUp(): void
    {
        $this->authorChange = $this->createStub(AuthorChange::class);

        $this->violation = $this->createMock(ConstraintViolationListInterface::class);

        /**
         * @var MockObject&ValidatorInterface $validator
         */
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('validate')
            ->with($this->identicalTo($this->authorChange))
            ->willReturn($this->violation);

        $this->authorChangeValidator = new AuthorChangeValidator($validator);
    }

    public function testValidate(): void
    {
        $this->violation->method('count')->willReturn(0);

        $this->authorChangeValidator->validate($this->authorChange);
    }

    public function testValidateWhenViolationIsNotEmpty(): void
    {
        $this->expectException(AuthorChangeValidationException::class);
        $this->expectExceptionMessage(
            AuthorChangeValidationException::VALIDATION_FAILED_MESSAGE
        );
    
        $this->violation->method('count')->willReturn(1);

        $this->authorChangeValidator->validate($this->authorChange);
    }
}
