<?php

namespace Slutsky\Library\Specification;

use DateTimeImmutable;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Expression;

class BookPublishedAfterSpecification implements BookSpecificationInterface
{
    private DateTimeImmutable $after;

    public function __construct(DateTimeImmutable $after)
    {
        $this->after = $after;
    }

    public function toExpression(): Expression
    {
        return Criteria::expr()->gte('publishedAt', $this->after);
    }
}
