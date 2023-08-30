<?php

namespace Slutsky\Library\Service;

use Doctrine\ORM\EntityManagerInterface;
use Slutsky\Library\Entity\Author;
use Slutsky\Library\Exception\AuthorNotFoundException;
use Slutsky\Library\Repository\AuthorRepositoryInterface;

class AuthorService
{
    private EntityManagerInterface $entityManger;
    private AuthorRepositoryInterface $authorRepository;

    public function __construct(
        EntityManagerInterface $entityManger,
        AuthorRepositoryInterface $authorRepository
    ) {
        $this->entityManger = $entityManger;
        $this->authorRepository = $authorRepository;
    }

    public function createAuthor(string $name): Author
    {
        $author = new Author($name);

        $this->authorRepository->add($author);

        $this->entityManger->flush();

        return $author;
    }

    /**
     * @throws AuthorNotFoundException
     */
    public function updateAuthor(int $authorId, string $name): Author
    {
        $author = $this->authorRepository->getById($authorId);

        $author->update($name);

        $this->entityManger->flush();

        return $author;
    }

    /**
     * @throws AuthorNotFoundException
     */
    public function removeAuthor(int $authorId): void
    {
        $author = $this->authorRepository->getById($authorId);

        $this->authorRepository->remove($author);

        $this->entityManger->flush();
    }
}
