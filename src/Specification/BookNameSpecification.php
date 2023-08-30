<?php

namespace Slutsky\Library\Specification;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Expression;

class BookNameSpecification implements BookSpecificationInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function toExpression(): Expression
    {
        return Criteria::expr()->eq('name', $this->name);
    }
}
