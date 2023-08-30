<?php

namespace Slutsky\Library\Repository;

use Slutsky\Library\Entity\Book;
use Slutsky\Library\Exception\BookNotFoundException;
use Slutsky\Library\Specification\BookSpecificationInterface;

interface BookRepositoryInterface
{
    /**
     * @throws BookNotFoundException
     */
    public function getById(int $bookId): Book;

    /**
     * @return Book[]
     */
    public function getAll(?BookSpecificationInterface $specification = null): array;

    public function add(Book $book): void;

    public function remove(Book $book): void;
}
