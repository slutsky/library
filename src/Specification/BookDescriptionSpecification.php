<?php

namespace Slutsky\Library\Specification;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Expression;

class BookDescriptionSpecification implements BookSpecificationInterface
{
    private string $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function toExpression(): Expression
    {
        return Criteria::expr()->contains('description', $this->description);
    }
}
