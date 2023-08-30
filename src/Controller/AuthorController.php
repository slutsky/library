<?php

namespace Slutsky\Library\Controller;

use Slutsky\Library\Exception\AuthorChangeSerializationException;
use Slutsky\Library\Exception\AuthorChangeValidationException;
use Slutsky\Library\Exception\AuthorNotFoundException;
use Slutsky\Library\Repository\AuthorRepositoryInterface;
use Slutsky\Library\Service\AuthorChangeSerializer;
use Slutsky\Library\Service\AuthorChangeValidator;
use Slutsky\Library\Service\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private AuthorRepositoryInterface $authorRepository;
    private AuthorService $authorService;
    private AuthorChangeSerializer $changeSerializer;
    private AuthorChangeValidator $changeValidator;

    public function __construct(
        AuthorRepositoryInterface $authorRepository,
        AuthorService $authorService,
        AuthorChangeSerializer $changeSerializer,
        AuthorChangeValidator $changeValidator
    ) {
        $this->authorRepository = $authorRepository;
        $this->authorService = $authorService;
        $this->changeSerializer = $changeSerializer;
        $this->changeValidator = $changeValidator;
    }

    /**
     * @Route("/authors", methods={"GET"})
     */
    public function getAuthorsAction(): JsonResponse
    {
        $authors = $this->authorRepository->getAll();

        return $this->json($authors);
    }

    /**
     * @Route("/authors/{authorsId}", methods={"GET"})
     *
     * @throws AuthorNotFoundException
     */
    public function getAuthorAction(int $authorsId): JsonResponse
    {
        $author = $this->authorRepository->getById($authorsId);

        return $this->json($author);
    }

    /**
     * @Route("/authors", methods={"POST"})
     *
     * @throws AuthorChangeSerializationException
     * @throws AuthorChangeValidationException
     */
    public function createAuthorAction(Request $request): JsonResponse
    {
        $change = $this->changeSerializer->deserialize($request);

        $this->changeValidator->validate($change);

        $author = $this->authorService->createAuthor($change->getName());

        return $this->json($author);
    }

    /**
     * @Route("/authors/{authorsId}", methods={"PUT"})
     *
     * @throws AuthorNotFoundException
     * @throws AuthorChangeSerializationException
     * @throws AuthorChangeValidationException
     */
    public function updateAuthorAction(int $authorsId, Request $request): JsonResponse
    {
        $change = $this->changeSerializer->deserialize($request);

        $this->changeValidator->validate($change);

        $author = $this->authorService->updateAuthor($authorsId, $change->getName());

        return $this->json($author);
    }

    /**
     * @Route("/authors/{authorsId}", methods={"DELETE"})
     *
     * @throws AuthorNotFoundException
     */
    public function removeAuthorAction(int $authorsId): JsonResponse
    {
        $this->authorService->removeAuthor($authorsId);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
