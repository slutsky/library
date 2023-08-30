<?php

namespace Slutsky\Library\Service;

use DateTimeImmutable;
use Slutsky\Library\Specification\BookAndSpecification;
use Slutsky\Library\Specification\BookCoverIdSpecification;
use Slutsky\Library\Specification\BookDescriptionSpecification;
use Slutsky\Library\Specification\BookNameSpecification;
use Slutsky\Library\Specification\BookOneOfAuthorIdSpecification;
use Slutsky\Library\Specification\BookPublishedAfterSpecification;
use Slutsky\Library\Specification\BookPublishedBeforeSpecification;
use Slutsky\Library\Specification\BookSpecificationInterface;
use Symfony\Component\HttpFoundation\Request;

class BookSpecificationFactory
{
    public function fromRequest(Request $request): ?BookSpecificationInterface
    {
        $specifications = [];

        if ($request->query->has('name')) {
            $specifications[] = new BookNameSpecification(
                $request->query->get('name')
            );
        }

        if ($request->query->has('author')) {
            $authorIds = $request->query->get('author');
            $authorIds = array_filter(
                $authorIds,
                static function (string $authorId) {
                    return preg_match('/^\d+$/', $authorId);
                }
            );
            $authorIds = array_map(
                static function (string $authorId) {
                    return (int)$authorId;
                },
                $authorIds,
            );

            $specifications[] = new BookOneOfAuthorIdSpecification($authorIds);
        }

        if ($request->query->has('description')) {
            $specifications[] = new BookDescriptionSpecification(
                $request->query->get('description')
            );
        }

        if ($request->query->has('cover')) {
            $specifications[] = new BookCoverIdSpecification(
                $request->query->getInt('cover')
            );
        }

        if ($request->query->has('publishedBefore')) {
            $specifications[] = new BookPublishedBeforeSpecification(
                new DateTimeImmutable($request->query->get('publishedBefore'))
            );
        }

        if ($request->query->has('publishedAfter')) {
            $specifications[] = new BookPublishedAfterSpecification(
                new DateTimeImmutable($request->query->get('publishedAfter'))
            );
        }

        if (empty($specifications)) {
            return null;
        }

        return new BookAndSpecification($specifications);
    }
}
