<?php
declare(strict_types=1);

namespace Ergnuor\Criteria\ValueSource;

use Stringable;

class ExpressionValueSource implements ValueSourceInterface, Stringable
{

    private string $expression;

    public function __construct(string $expression)
    {
        $this->expression = $expression;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function __toString(): string
    {
        return $this->getExpression();
    }
}