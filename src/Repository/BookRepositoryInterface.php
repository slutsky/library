<?php

namespace Slutsky\Library\Repository;

use Slutsky\Library\Entity\Book;
use Slutsky\Library\Exception\BookNotFoundException;

interface BookRepositoryInterface
{
    /**
     * @throws BookNotFoundException
     */
    public function getById(int $bookId): Book;

    /**
     * @return Book[]
     */
    public function getAll(): array;

    public function add(Book $book): void;

    public function remove(Book $book): void;
}
