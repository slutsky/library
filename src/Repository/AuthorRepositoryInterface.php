<?php

namespace Slutsky\Library\Repository;

use Slutsky\Library\Entity\Author;
use Slutsky\Library\Exception\AuthorNotFoundException;

interface AuthorRepositoryInterface
{
    /**
     * @throws AuthorNotFoundException
     */
    public function getById(int $authorId): Author;

    /**
     * @param int[] $authorIds
     *
     * @return Author[]
     */
    public function getByIds(array $authorIds): array;

    /**
     * @return Author[]
     */
    public function getAll(): array;

    public function add(Author $author): void;

    public function remove(Author $author): void;
}
