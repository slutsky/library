<?php

namespace Slutsky\Library\Tests\Entity;

use DateTimeImmutable;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Slutsky\Library\Entity\Author;
use Slutsky\Library\Entity\Book;
use Slutsky\Library\Entity\FileInfo;

class BookTest extends TestCase
{
    private const NAME = 'Book name';
    private const DESCRIPTION = 'Book description';
    
    /**
     * @var Stub&FileInfo
     */
    private Stub $cover;

    /**
     * @var Stub&Author
     */
    private Stub $author;

    private DateTimeImmutable $publishedAt;

    private Book $book;

    protected function setUp(): void
    {
        $this->publishedAt = new DateTimeImmutable();
        $this->cover = $this->createStub(FileInfo::class);
        $this->author = $this->createStub(Author::class);

        $this->book = new Book(
            self::NAME,
            [$this->author],
            self::DESCRIPTION,
            $this->cover,
            $this->publishedAt,
        );
    }

    public function testCreation(): void
    {
        $this->assertEquals(self::NAME, $this->book->getName());
        $this->assertContains($this->author, $this->book->getAuthors());
        $this->assertEquals(self::DESCRIPTION, $this->book->getDescription());
        $this->assertEquals($this->cover, $this->book->getCover());
        $this->assertEquals($this->publishedAt, $this->book->getPublishedAt());
    }

    public function testUpdate(): void
    {
        $newName = 'New name';
        $newDescription = 'New description';
        $newCover = $this->createStub(FileInfo::class);
        $newAuthor = $this->createStub(Author::class);
        $newPublishedAt = new DateTimeImmutable();

        $this->book->update(
            $newName,
            [$newAuthor],
            $newDescription,
            $newCover,
            $newPublishedAt,
        );

        $this->assertEquals($newName, $this->book->getName());
        $this->assertContains($newAuthor, $this->book->getAuthors());
        $this->assertEquals($newDescription, $this->book->getDescription());
        $this->assertEquals($newCover, $this->book->getCover());
        $this->assertEquals($newPublishedAt, $this->book->getPublishedAt());
    }
}
