<?php

namespace Slutsky\Library\Specification;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Expression;

class BookAndSpecification implements BookSpecificationInterface
{
    /**
     * @var BookSpecificationInterface[]
     */
    private array $specifications;

    /**
     * @param BookSpecificationInterface[] $specifications
     */
    public function __construct(array $specifications)
    {
        $this->specifications = $specifications;
    }

    public function toExpression(): Expression
    {
        return Criteria::expr()->andX(...array_map(
            static function (BookSpecificationInterface $specification) {
                return $specification->toExpression();
            },
            $this->specifications,
        ));
    }
}
