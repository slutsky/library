<?php

namespace Slutsky\Library\Specification;

use DateTimeImmutable;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Expression;

class BookPublishedBeforeSpecification implements BookSpecificationInterface
{
    private DateTimeImmutable $before;

    public function __construct(DateTimeImmutable $before)
    {
        $this->before = $before;
    }

    public function toExpression(): Expression
    {
        return Criteria::expr()->lte('publishedAt', $this->before);
    }
}
