<?php

namespace Slutsky\Library\Controller;

use Slutsky\Library\Dto\BookFilter;
use Slutsky\Library\Repository\BookRepositoryInterface;
use Slutsky\Library\Service\BookChangeSerializer;
use Slutsky\Library\Service\BookChangeValidator;
use Slutsky\Library\Service\BookService;
use Slutsky\Library\Service\BookSpecificationFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    private BookRepositoryInterface $bookRepository;
    private BookService $bookService;
    private BookChangeSerializer $changeSerializer;
    private BookChangeValidator $changeValidator;
    private BookSpecificationFactory $bookSpecificationFactory;

    public function __construct(
        BookRepositoryInterface $bookRepository,
        BookService $bookService,
        BookChangeSerializer $changeSerializer,
        BookChangeValidator $changeValidator,
        BookSpecificationFactory $bookSpecificationFactory
    ) {
        $this->bookRepository = $bookRepository;
        $this->bookService = $bookService;
        $this->changeSerializer = $changeSerializer;
        $this->changeValidator = $changeValidator;
        $this->bookSpecificationFactory = $bookSpecificationFactory;
    }

    /**
     * @Route("/books", methods={"GET"})
     */
    public function getBooksAction(Request $request): JsonResponse
    {
        $specification = $this->bookSpecificationFactory->fromRequest($request);

        $books = $this->bookRepository->getAll($specification);

        return $this->json($books);
    }

    /**
     * @Route("/books/{booksId}", methods={"GET"})
     *
     * @throws BookNotFoundException
     */
    public function getBookAction(int $booksId): JsonResponse
    {
        $book = $this->bookRepository->getById($booksId);

        return $this->json($book);
    }

    /**
     * @Route("/books", methods={"POST"})
     *
     * @throws FileInfoNotFoundException
     * @throws BookChangeSerializationException
     * @throws BookChangeValidationException
     */
    public function createBookAction(Request $request): JsonResponse
    {
        $change = $this->changeSerializer->deserialize($request);

        $this->changeValidator->validate($change);

        $book = $this->bookService->createBook(
            $change->getName(),
            $change->getAuthors(),
            $change->getDescription(),
            $change->getCover(),
            $change->getPublishedAt(),
        );

        return $this->json($book);
    }

    /**
     * @Route("/books/{booksId}", methods={"PUT"})
     *
     * @throws AuthorNotFoundException
     * @throws FileInfoNotFoundException
     * @throws BookNotFoundException
     * @throws BookChangeSerializationException
     * @throws BookChangeValidationException
     */
    public function updateBookAction(int $booksId, Request $request): JsonResponse
    {
        $change = $this->changeSerializer->deserialize($request);

        $this->changeValidator->validate($change);

        $book = $this->bookService->updateBook(
            $booksId,
            $change->getName(),
            $change->getAuthors(),
            $change->getDescription(),
            $change->getCover(),
            $change->getPublishedAt(),
        );

        return $this->json($book);
    }

    /**
     * @Route("/books/{booksId}", methods={"DELETE"})
     *
     * @throws BookNotFoundException
     */
    public function removeBookAction(int $booksId): JsonResponse
    {
        $this->bookService->removeBook($booksId);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
