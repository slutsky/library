<?php

namespace Slutsky\Library\Event;

use Slutsky\Library\Entity\Book;

class BookEvent
{
    private Book $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function getBook(): Book
    {
        return $this->book;
    }
}
