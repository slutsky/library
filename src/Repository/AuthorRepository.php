<?php

namespace Slutsky\Library\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Slutsky\Library\Entity\Author;
use Slutsky\Library\Exception\AuthorNotFoundException;

class AuthorRepository extends ServiceEntityRepository implements
    AuthorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * @throws AuthorNotFoundException
     */
    public function getById(int $authorId): Author
    {
        $author = $this->find($authorId);

        if (null === $author) {
            throw AuthorNotFoundException::create();
        }

        return $author;
    }

    /**
     * @param int[] $authorIds
     *
     * @return Author[]
     */
    public function getByIds(array $authorIds): array
    {
        return $this->findBy(['id' => $authorIds]);
    }

    /**
     * @return Author[]
     */
    public function getAll(): array
    {
        return $this->findAll();
    }

    public function add(Author $author): void
    {
        $this->getEntityManager()->persist($author);
    }

    public function remove(Author $author): void
    {
        $this->getEntityManager()->remove($author);
    }
}
