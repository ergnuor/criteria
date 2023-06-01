<?php

declare(strict_types=1);

namespace Ergnuor\Criteria\Expression;

class NegationExpression implements ExpressionInterface
{
    private ExpressionInterface $expression;

    public function __construct(ExpressionInterface $expression)
    {
        $this->expression = $expression;
    }

    public function getExpression(): ExpressionInterface
    {
        return $this->expression;
    }
}
