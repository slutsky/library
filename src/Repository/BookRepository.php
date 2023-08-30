<?php

namespace Slutsky\Library\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Slutsky\Library\Entity\Book;
use Slutsky\Library\Exception\BookNotFoundException;
use Slutsky\Library\Specification\BookSpecificationInterface;

class BookRepository extends ServiceEntityRepository implements
    BookRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @throws BookNotFoundException
     */
    public function getById(int $bookId): Book
    {
        $book = $this->find($bookId);

        if (null === $book) {
            throw BookNotFoundException::create();
        }

        return $book;
    }

    /**
     * @return Book[]
     */
    public function getAll(?BookSpecificationInterface $specification = null): array
    {
        $queryBuilder = $this->createQueryBuilder('book');

        if (null !== $specification) {
            $queryBuilder->innerJoin('book.authors', 'author');
            $queryBuilder->addCriteria(new Criteria($specification->toExpression()));
        }

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function add(Book $book): void
    {
        $this->getEntityManager()->persist($book);
    }

    public function remove(Book $book): void
    {
        $this->getEntityManager()->remove($book);
    }
}
