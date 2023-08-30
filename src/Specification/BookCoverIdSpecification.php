<?php

namespace Slutsky\Library\Specification;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Expression;

class BookCoverIdSpecification implements BookSpecificationInterface
{
    private int $coverId;

    public function __construct(int $coverId)
    {
        $this->coverId = $coverId;
    }

    public function toExpression(): Expression
    {
        return Criteria::expr()->eq('cover', $this->coverId);
    }
}
