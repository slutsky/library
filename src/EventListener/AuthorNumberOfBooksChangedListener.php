<?php

namespace Slutsky\Library\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Slutsky\Library\Event\BookCreatedEvent;
use Slutsky\Library\Event\BookRemovedEvent;
use Slutsky\Library\Repository\AuthorRepositoryInterface;

class AuthorNumberOfBooksChangedListener
{
    private EntityManagerInterface $entityManager;
    private AuthorRepositoryInterface $authorRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        AuthorRepositoryInterface $authorRepository
    ) {
        $this->entityManager = $entityManager;
        $this->authorRepository = $authorRepository;
    }

    public function increaseNumberOfBookByAuthor(BookCreatedEvent $event): void
    {
        $authors = $event->getBook()->getAuthors();
        foreach ($authors as $author) {
            $this->authorRepository->increaseNumberOfBooksBy($author->getId());
        }

        $this->entityManager->flush();
    }

    public function decreaseNumberOfBookByAuthor(BookRemovedEvent $event): void
    {
        $authors = $event->getBook()->getAuthors();
        foreach ($authors as $author) {
            $this->authorRepository->decreaseNumberOfBooksBy($author->getId());
        }

        $this->entityManager->flush();
    }
}
