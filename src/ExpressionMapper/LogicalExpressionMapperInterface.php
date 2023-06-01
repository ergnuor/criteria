<?php
declare(strict_types=1);

namespace Ergnuor\Criteria\ExpressionMapper;

interface LogicalExpressionMapperInterface
{
    public function orX(...$x): mixed;

    public function andX(...$x): mixed;

    public function not($expression): mixed;
}