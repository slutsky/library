<?php

namespace Slutsky\Library\Tests\Entity;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Slutsky\Library\Entity\Author;
use Slutsky\Library\Repository\AuthorRepositoryInterface;
use Slutsky\Library\Service\AuthorService;

class AuthorServiceTest extends TestCase
{
    private const AUTHOR_ID = 4;

    /**
     * @var MockObject&EntityManagerInterface
     */
    private MockObject $entityManager;

    /**
     * @var MockObject&AuthorRepositoryInterface
     */
    private MockObject $authorRepository;

    /**
     * @var MockObject&Author
     */
    private MockObject $author;

    private AuthorService $authorService;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        /**
         * @var MockObject&Author $author
         */
        $author = $this->createMock(Author::class);
        $author->method('getId')->willReturn(self::AUTHOR_ID);
        $this->author = $author;

        /**
         * @var MockObject&AuthorRepositoryInterface $authorRepository
         */
        $authorRepository = $this->createMock(AuthorRepositoryInterface::class);
        $authorRepository->method('getById')->willReturn($this->author);
        $this->authorRepository = $authorRepository;

        $this->authorService = new AuthorService(
            $this->entityManager,
            $this->authorRepository,
        );
    }

    public function testCreation(): void
    {
        $name = 'Author Name';

        $this->entityManager->expects($this->once())->method('flush');
        $this->authorRepository->expects($this->once())->method('add');

        $author = $this->authorService->createAuthor($name);

        $this->assertEquals($name, $author->getName());
    }

    public function testUpdate(): void
    {
        $newName = 'New Name';

        $this->entityManager->expects($this->once())->method('flush');

        $this->author->expects($this->once())
            ->method('update')
            ->with($this->equalTo($newName));

        $this->authorService->updateAuthor(self::AUTHOR_ID, $newName);
    }

    public function testRemoveAuthor(): void
    {
        $this->entityManager->expects($this->once())->method('flush');

        $this->authorRepository->expects($this->once())
            ->method('remove')
            ->with($this->identicalTo($this->author));

        $this->authorService->removeAuthor(self::AUTHOR_ID);
    }
}
