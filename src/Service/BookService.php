<?php

namespace Slutsky\Library\Service;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Slutsky\Library\Entity\Book;
use Slutsky\Library\Exception\AuthorNotFoundException;
use Slutsky\Library\Exception\BookNotFoundException;
use Slutsky\Library\Exception\FileInfoNotFoundException;
use Slutsky\Library\Repository\AuthorRepositoryInterface;
use Slutsky\Library\Repository\BookRepositoryInterface;
use Slutsky\Library\Repository\FileInfoRepositoryInterface;

class BookService
{
    private EntityManagerInterface $entityManger;
    private BookRepositoryInterface $bookRepository;
    private AuthorRepositoryInterface $authorRepository;
    private FileInfoRepositoryInterface $fileInfoRepository;

    public function __construct(
        EntityManagerInterface $entityManger,
        BookRepositoryInterface $bookRepository,
        AuthorRepositoryInterface $authorRepository,
        FileInfoRepositoryInterface $fileInfoRepository
    ) {
        $this->entityManger = $entityManger;
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
        $this->fileInfoRepository = $fileInfoRepository;
    }

    /**
     * @param int[] $authors
     *
     * @throws AuthorNotFoundException
     * @throws FileInfoNotFoundException
     */
    public function createBook(
        string $name,
        array $authorIds,
        string $description,
        int $coverId,
        DateTimeImmutable $publishedAt
    ): Book {
        $authors = $this->authorRepository->getByIds($authorIds);
        $cover = $this->fileInfoRepository->getById($coverId);

        $book = new Book(
            $name,
            $authors,
            $description,
            $cover,
            $publishedAt,
        );

        $this->bookRepository->add($book);

        $this->entityManger->flush();

        return $book;
    }

    /**
     * @param int[] $authorIds
     *
     * @throws BookNotFoundException
     * @throws AuthorNotFoundException
     * @throws FileInfoNotFoundException
     */
    public function updateBook(
        int $bookId,
        string $name,
        array $authorIds,
        string $description,
        int $coverId,
        DateTimeImmutable $publishedAt
    ): Book {
        $book = $this->bookRepository->getById($bookId);
        $authors = $this->authorRepository->getByIds($authorIds);
        $cover = $this->fileInfoRepository->getById($coverId);

        $book->update(
            $name,
            $authors,
            $description,
            $cover,
            $publishedAt,
        );

        $this->entityManger->flush();

        return $book;
    }

    /**
     * @throws BookNotFoundException
     */
    public function removeBook(int $bookId): void
    {
        $book = $this->bookRepository->getById($bookId);

        $this->bookRepository->remove($book);

        $this->entityManger->flush();
    }
}
