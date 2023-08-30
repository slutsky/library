<?php

namespace Slutsky\Library\Specification;

use Doctrine\Common\Collections\Expr\Expression;

interface BookSpecificationInterface
{
    public function toExpression(): Expression;
}
