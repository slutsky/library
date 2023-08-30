<?php

namespace Slutsky\Library\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Slutsky\Library\Entity\Author;

class AuthorTest extends TestCase
{
    private const NAME = 'Author Name';

    private Author $author;

    protected function setUp(): void
    {
        $this->author = new Author(self::NAME);
    }

    public function testCreation(): void
    {
        $this->assertEquals(self::NAME, $this->author->getName());
    }

    public function testUpdate(): void
    {
        $newName = 'New Name';

        $this->author->update($newName);

        $this->assertEquals($newName, $this->author->getName());
    }
}
