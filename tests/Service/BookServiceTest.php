<?php

namespace Slutsky\Library\Tests\Entity;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Slutsky\Library\Entity\Author;
use Slutsky\Library\Entity\Book;
use Slutsky\Library\Entity\FileInfo;
use Slutsky\Library\Event\BookCreatedEvent;
use Slutsky\Library\Event\BookRemovedEvent;
use Slutsky\Library\Repository\AuthorRepositoryInterface;
use Slutsky\Library\Repository\BookRepositoryInterface;
use Slutsky\Library\Repository\FileInfoRepositoryInterface;
use Slutsky\Library\Service\BookService;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class BookServiceTest extends TestCase
{
    /**
     * @var Stub&Author
     */
    private Stub $author;

    /**
     * @var Stub&FileInfo
     */
    private Stub $cover;

    /**
     * @var MockObject&Book
     */
    private MockObject $book;

    /**
     * @var MockObject&EntityManagerInterface
     */
    private MockObject $entityManager;

    /**
     * @var MockObject&EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @var MockObject&BookRepositoryInterface
     */
    private MockObject $bookRepository;

    private BookService $bookService;

    protected function setUp(): void
    {
        $this->author = $this->createStub(Author::class);

        $this->cover = $this->createStub(FileInfo::class);

        $this->book = $this->createMock(Book::class);

        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        /**
         * @var MockObject&BookRepositoryInterface $bookRepository
         */
        $bookRepository = $this->createMock(BookRepositoryInterface::class);
        $bookRepository->method('getById')->willReturn($this->book);
        $this->bookRepository = $bookRepository;

        /**
         * @var MockObject&AuthorRepositoryInterface $authorRepository
         */
        $authorRepository = $this->createMock(AuthorRepositoryInterface::class);
        $authorRepository->method('getByIds')->willReturn([$this->author]);

        /**
         * @var MockObject&FileInfoRepositoryInterface $fileInfoRepository
         */
        $fileInfoRepository = $this->createMock(FileInfoRepositoryInterface::class);
        $fileInfoRepository->method('getById')->willReturn($this->cover);

        $this->bookService = new BookService(
            $this->entityManager,
            $this->eventDispatcher,
            $this->bookRepository,
            $authorRepository,
            $fileInfoRepository
        );
    }

    public function testCreation(): void
    {
        $name = 'Book Name';
        $authorId = 5;
        $description = 'Description';
        $coverId = 7;
        $publishedAt = new DateTimeImmutable();

        $this->entityManager->expects($this->once())->method('flush');
        $this->bookRepository->expects($this->once())->method('add');

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(BookCreatedEvent::class));

        $book = $this->bookService->createBook(
            $name,
            [$authorId],
            $description,
            $coverId,
            $publishedAt,
        );

        $this->assertEquals($name, $book->getName());
        $this->assertContains($this->author, $book->getAuthors());
        $this->assertEquals($description, $book->getDescription());
        $this->assertEquals($this->cover, $book->getCover());
        $this->assertEquals($publishedAt, $book->getPublishedAt());
    }

    public function testUpdate(): void
    {
        $bookId = 4;
        $newName = 'Book Name';
        $authorId = 5;
        $newDescription = 'Description';
        $newCoverId = 8;
        $newPublishedAt = new DateTimeImmutable();

        $this->entityManager->expects($this->once())->method('flush');

        $this->book->expects($this->once())->method('update')->with(
            $this->equalTo($newName),
            $this->containsIdentical($this->author),
            $this->equalTo($newDescription),
            $this->equalTo($this->cover),
            $this->equalTo($newPublishedAt),
        );

        $book = $this->bookService->updateBook(
            $bookId,
            $newName,
            [$authorId],
            $newDescription,
            $newCoverId,
            $newPublishedAt,
        );

        $this->assertSame($this->book, $book);
    }

    public function testRemoveBook(): void
    {
        $bookId = 4;

        $this->entityManager->expects($this->once())->method('flush');
        $this->bookRepository->expects($this->once())->method('remove');

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(BookRemovedEvent::class));

        $this->bookService->removeBook($bookId);
    }
}
