<?php

namespace Slutsky\Library\Specification;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Expression;

class BookOneOfAuthorIdSpecification implements BookSpecificationInterface
{
    /**
     * @var int[]
     */
    private array $authorIds;

    /**
     * @param int[] $authorIds
     */
    public function __construct(array $authorIds)
    {
        $this->authorIds = $authorIds;
    }

    public function toExpression(): Expression
    {
        return Criteria::expr()->in('author', $this->authorIds);
    }
}
